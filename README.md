## 前言

​	在這個簡單的專案中，你可以學習到前端、後端與基本容器的概念，前端網頁的部分我採用了 Vue + taiwind.css 做為我前端快速開發的框架，後端則是採用了 Laradock，利用docker這項技術避免環境不依所造成不可預期的後果。

​	此專案前端技術著重在於即時表單驗證及一些良好的使用者體驗，後端的部分著重在於 PHP 資料切割，將IG 的 API Response 切割成自己所想要的形式並回傳給前端。

#### 注意

- IG會將Data Center(GCP、AWS、Linode ...)的IP鎖起來，如果過度頻繁操作API，可能會被IG偵測為異常，鎖住帳號使用API登入一段時間，須待解鎖後才能再度抽獎。

  ![](https://i.imgur.com/OMFWMeV.png)

- 上述問題可能可以透過更換主機IP解決，如果架在雲端，可以透過重啟instance的方式換IP，如果不想一直換IP可能可以透過residential proxy解決，一般住宅使用的IP我還沒有遇過不能使用的情況(沒被鎖過)。

## 展示

[影片DEMO](https://youtu.be/8rdEbsL2ZNs)

[網頁DEMO (因IG會擋數據中心IP，故有時網站會掛掉哦，如果用家用IP比較不會，或是嘗試用Proxy可能也可以)](https://iglottery.r-dap.com)

## 後端邏輯實現流程

**定義 api 參數:**

​	標記人數 markPeopleCount

​	抽獎連結 url string

​	抽獎人數 peopleCount int

​	重複留言 canRepeatComment true/false

​	排除自己 excludeMe true/false

​	限制留言格式 limitComment 不限制設false

​	限制留言時間 limitTime int/false;

**分析流程:**

​	判斷是否排除發文人的留言 -> 判斷可否重複留言 ->  判斷限制留言格式 -> 判斷超過限制時間 -> 判斷tag人數 -> 抽	獎。



​	假設連結為'https://www.instagram.com/p/CTi3Y4VhJmx'，先用 '/' 做切割，形式為 list = ["https:","","www.instagr	am.com","p","CTi3Y4VhJmx"]，會發現list[4]固定為IG文章的short code，此時使用Instagram PHP Scraper 的		                              	getMediaCommentsByCode獲取文章資訊。



​	**此時遍歷回傳的所有留言，留言參數分析分成7大塊 :**

1. **判斷是否排除發文人的留言：**

​			如果發現參數excludeMe == true 且文章的PO文人與留言人相同則利用迴圈continue的方式跳過迴圈。

2. **判斷可否重複留言：**

​			宣告一個空陣列，如果canRepeatComment == true ，則將留言的帳號資訊append到陣列中，如果下則留言的			帳號已存在在陣列中的話，直接不記錄這則留言。

3. **判斷限制留言格式：**

​			如果limitComment != false(代表有設定留言格式，非false即String) 且 留言的字串中沒包含我所設定的字串則			不記錄此留言。

4. **判斷超過限制時間：**

​			時間記錄使用Unix time stamp，如果limitTime != false (代表有設定時間限制，非false即int) 且 留言的時間 > 我			限制的時間，則不記錄留言。

5. **判斷tag人數：**

​			利用regex正則表示式，`$pattern = "/^@([0-9a-z._]+)$/";`，根據IG帳戶ID命名規則，帳號可以由0 - 			9、a-z、.、_、所組成，並且可以觀察到留言標記中 @janet.lin @1rhema_an 芋泥我可以❤️，標記帳號後方會			產生空格我們則利用空格去做資料切割，會切成list = ['@janet.lin','@1rhema_an','芋泥我可以❤️'] 這樣的形			式，則後只需遍歷陣列，如果該元素符合正則表示式則countTagNumber++; 紀錄標記人數，那最後如果標記			人數 < 我所設定的markPeopleCount則不記錄此留言。 

  6. **存入符合資格的留言至陣列中**

  7. **抽獎 ：**

     假設要抽的人數>留言人數則做例外處理，將所有留言直接輸出成中獎留言。

     宣告一個留言數(元素個素)長度為n的陣列，初始化元素 0 ~ n-1，並使用array_rand() 函數從數組中隨機選出一個或多個元素並返回抽出的結果。

     

## 環境架設

#### 環境資訊 ：

- Laradock
- PHP 7.3.29
- NodeJs  16.4.2
- npm 7.18.1
- Laravel 8

### 環境配置：

#### Ubuntu 18.04 :

1. 遠端更新伺服器的套件檔案清單

   `$ sudo apt-get update` 

2. 安裝 Git

   `$ sudo apt install git`

3. 安裝 Curl

   `$ sudo apt install curl`

4. 安裝 Docker  Compose

   `$ sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose `

   

   `$ sudo chmod +x /usr/local/bin/docker-compose`

5. 確認有無安裝好 Docker Compose

   `$ docker–compose –version`

   `docker-compose version 1.29.2, build 5becea4c`

6. 下載專案至本地

   `$ git clone https://github.com/Ryan45758/ig-lottery.git`

7. cd 進 laradock 資料夾

   `$ cd ig-lottery/laradock`

8. 配置 laradock .env

   `$ cp .env.example .env`
   
9. 配置laradock nginx

   `$ sudo cp ig-lottery/laradock/nginx/sites/ig-lottery.conf.example ig-lottery/laradock/nginx/sites/ig-lottery.conf`

   並更改 your_domain為你的網域 

   `$ sudo vi ig-lottery/laradock/nginx/sites/ig-lottery.conf`

   <img src="https://i.imgur.com/5QucT69.png" />

10. 安裝 laradock 所需環境 nginx、mysql

   `/ig-lottery/laradock$ sudo docker-compose up -d nginx mysql`

11. 進入容器內

    `/ig-lottery/laradock$ sudo docker-compose exec workspace bash`

    `root@558717f0b5d4:/var/www# cd ig_lottery/ `

12. 配置laravel .env

    `root@558717f0b5d4:/var/www/ig_lottery# cp .env.example .env`

13. 下載laravel 套件 及 vue

    `root@558717f0b5d4:/var/www/ig_lottery# composer install --ignore-platform-reqs`

    `root@558717f0b5d4:/var/www/ig_lottery# npm install`

14. 編譯vue tailwind

    `root@558717f0b5d4:/var/www/ig_lottery# npm run production`

15. 配置laravel key

    `root@558717f0b5d4:/var/www/ig_lottery# php artisan key:generate`

16. 進行資料庫遷移

    `root@558717f0b5d4:/var/www/ig_lottery# php artisan migrate`

17. ctrl + d 退出容器

18. 配置主機 host

    `$ sudo vim /etc/hosts`

    新增

    `127.0.0.1 'your_domain'`

    保存，退出

19. 瀏覽器瀏覽就有網頁拉！但別急laravel還沒配置完成

    `ig-lottery/www/ig_lottery/app/Http/Controllers/LotteryController.php`的第25行 'ig_username'、'ig_password'必須填成個人帳號的帳號及密碼。這樣就可以抽獎拉！

    此時你會發現抽獎出來的照片無法顯示。因為IG禁止跨域請求，必須要配置cloudflare worker，才可以。

    [CloudFlare IG Worker配置教學](https://gist.github.com/restyler/6c51e3ad20d7596e799d76e87cf93236)

    配置完畢後，將第71行`'cloud flare worker url'.$value->getOwner()->getProfilePicUrl()`的'cloud flare worker url'內容改成worker的網址就可以瀏覽IG照片拉！

#### Windows 10 :

1. Windows只有1~5的安裝docker步驟不同而已，其餘皆相同。安裝[docker-desktop](https://www.docker.com/products/docker-desktop) 即可。
2. 更改Host，可參考此篇[教學](https://blog.gtwang.org/windows/windows-linux-hosts-file-configuration/)。

