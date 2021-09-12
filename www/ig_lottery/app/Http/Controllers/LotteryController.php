<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phpfastcache\Helper\Psr16Adapter;
use App\Models\BenefitCount;
use App\Models\VisitedCount;
use App\Mail\sendWebDieMail;
use Illuminate\Support\Facades\Mail;

class LotteryController extends Controller
{
    /**
    * 訪問IG API並抽獎
    * @param int $markPeopleCount (標記人數)
    * @param string $url (抽獎連結)
    * @param int $peopleCount (抽獎人數)
    * @param boolean $canRepeatComment (重複留言)
    * @param boolean $excludeMe (是否排除自己)
    * @param boolean $limitComment (限制留言格式，不限制設格式則false，否則為string)
    * @param boolean $limitTime (限制留言時間，不限制設格式則false，否則為int)
    * @return json
    */
    public function lottery(Request $request)
    {
        $pattern = "/^@([0-9a-z._]+)$/";
        $url =mb_split("/", $request->url); //根據/切開
        $instagram = \InstagramScraper\Instagram::withCredentials(
            new \GuzzleHttp\Client(), 
            'ig_username', 
            'ig_password', 
            new Psr16Adapter('Files')
        ); //本行需修改帳號密碼
        $instagram->login();
        $instagram->saveSession();
        $user_data_set = [];
        $user_name_data_set = [];
        $user_data_csv_set =[];
        // Get media comments by shortcode
        $comments = $instagram->getMediaCommentsByCode($url[4], 8000);
        $media = $instagram->getMediaByCode($url[4]);
        //獲取留言，並且依條件獲取
        foreach ($comments as $key => $value) {
            //如果排除我，則跳過迴圈
            if ($request->excludeMe == true && $media->getOwner()->getUsername() == $value->getOwner()->getUsername()) {
                continue;
            }
            //不可重複留言
            if ($request->canRepeatComment == false) {
                if (!in_array($value->getOwner()->getUsername(), $user_name_data_set)) {
                    //如果有重複留言，跳出迴圈
                    array_push($user_name_data_set, $value->getOwner()->getUsername());
                } else {
                    continue;
                }
            }
            
            $countTagNumber = 0;
            //限制留言格式
            if ($request->limitComment != false && strpos($value->getText(), $request->limitComment) == false) {
                continue;
            }
            $contents = mb_split(" ", $value->getText());
      
          
            //如果超過限制時間
            if ($request->limitTime != false && $request->limitTime < $value->getCreatedAt()) {
                continue;
            }
            //判斷tag人數
            foreach ($contents as $content) {
                if (preg_match($pattern, $content)) {
                    $countTagNumber++;
                }
            }
            if ($countTagNumber >= $request->markPeopleCount) {
                $user_data = [
                    "userName" => $value->getOwner()->getUsername(),
                    "header" => 'cloud flare worker url'.$value->getOwner()->getProfilePicUrl(), //本行需修改網址
                    "id" => $value->getId(),
                    "create_at" => $value->getCreatedAt(),
                    "content" => $value->getText(),
                    "commentUserId" => $value->getOwner()->getId(),
                ];
                $user_data_csv =[
                    "用戶" => $value->getOwner()->getUsername(),
                    "留言" => $value->getText(),
                    "建立時間" => gmdate("Y-m-d H:i:s", $value->getCreatedAt()),
                    "標記人數" => $countTagNumber,
                    "個人檔案" => 'https://www.instagram.com/'.$value->getOwner()->getUsername().'/'
                    
                ];
                array_push($user_data_set, $user_data);
                array_push($user_data_csv_set, $user_data_csv);
            }
        }
        //-----------------------------抽獎----------------------------------
        $count = 0;
        $random_int = array();
        $peopleCount = $request->peopleCount;
        //如果要抽的人數>留言人數 例外處理
        if ($peopleCount > count($user_data_set)) {
            $peopleCount = count($user_data_set);
        }
        while ($count < $peopleCount) {
            $random_int[] = mt_rand(0, count($user_data_set)-1);
            $random_int = array_flip(array_flip($random_int));
            $count = count($random_int);
        }
        //打亂數組並重新為數組分配一個新的下標
        shuffle($random_int);
        $lottery_result = [];
        foreach ($random_int as $random) {
            array_push($lottery_result, $user_data_set[$random]);
        }
        BenefitCount::create(['visitor'=>$request->ip()]);
        //--------------------------------------------------------------------
        return response()->json([
            "lottery_result" => $lottery_result,
            "data" => $user_data_set,
            "user_data_csv" => $user_data_csv_set
        ]);
    }

    /**
    * 回傳首頁
    */
    public function index(Request $request)
    {
        $visitor = VisitedCount::create([
            'visitor' => $request->ip()
        ]);
        //如果獲益人數沒資料，直接回傳0
        $benefitor = BenefitCount::latest('id')->first();
        if (!$benefitor) {
            return view('lottery', ['VisitedCount' => $visitor->id,'BenefitCount'=>0]);
        }
        return view('lottery', ['VisitedCount' => $visitor->id,'BenefitCount'=>$benefitor->id]);
    }
}
