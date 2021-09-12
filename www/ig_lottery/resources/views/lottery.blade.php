<!DOCTYPE html>
<html lang="en" class="dar" ref="html">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Language" content="zh-TW">
  <meta name="distribution" content="TaiWan">
  <meta name="author" content="ryan45758@gmail.com">
  <meta name="copyright" content="ryan45758@gmail.com">
  <meta name="description" content="IgLottery是一個完全免費的IG抽獎網站，你只需要將你想抽獎的貼文連結貼上，按照你想要的功能做設定，就可以抽獎拉~，是不是很方便呢？趕快試用看看！">
  <meta name="keywords"
    content="抽獎程式 instagram IG instagram抽獎 iglottery IgLottery ig抽獎 ig抽獎器 ig抽獎神器 Ig抽獎 Ig抽獎器 Ig抽獎神器 IG抽獎 IG抽獎器 IG抽獎神器 instagram 免費 抽獎 抽獎ig">
  <meta property="og:title" content="IG抽獎 | IgLottery" />
  <meta property="og:description"
    content="IgLottery是一個完全免費的IG抽獎網站，你只需要將你想抽獎的貼文連結貼上，按照你想要的功能做設定，就可以抽獎拉~，是不是很方便呢？趕快試用看看！" />
  <meta property="og:type" content="article" />
  <meta name=title content="IG抽獎 | IgLottery">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="{{ asset('font.js') }}"></script>
  <title>IG抽獎 | IgLottery</title>
  <link rel="icon" href="{{ URL::asset('img/R-DAP32x32.ico') }}" type="image/x-icon" />
</head>
<style>
  body {
    -webkit-tap-highlight-color: transparent !important;
    font-family: 'Raleway', sans-serif !important;
    overflow-y: scroll;
  }

  /* 變更placeholder顏色 */
  ::placeholder {
    /* CSS 3 標準 */
    --tw-text-opacity: 1 !important;
    color: rgba(107, 114, 128, var(--tw-text-opacity)) !important;

  }

  ::-webkit-input-placeholder {
    /* Chrome, Safari */
    --tw-text-opacity: 1 !important;
    color: rgba(107, 114, 128, var(--tw-text-opacity)) !important;

  }

  :-ms-input-placeholder {
    /* IE 10+ */
    --tw-text-opacity: 1 !important;
    color: rgba(107, 114, 128, var(--tw-text-opacity)) !important;

  }

  ::-moz-placeholder {
    /* Firefox 19+ */
    --tw-text-opacity: 1 !important;
    color: rgba(107, 114, 128, var(--tw-text-opacity)) !important;

  }
</style>

<body class="antialiased font-sans bg-gray-200 dark:bg-black">
  <div class="" id="Bg">
    <particles-bg type="tadpole" :bg="true" />
  </div>
  <div class="sticky top-0 z-50" id="nav-bar">
    <nav-bar :visited-count="'{{$VisitedCount}}'" :benefit-count="'{{$BenefitCount}}'"></nav-bar>
  </div>
  <div class="" id="IgLotteryForm">
    <ig-lottery-form></ig-lottery-form>
  </div>
  <div class="" id="CommentTable">
    <comment-table></comment-table>
  </div>


  <script src="{{ mix('/js/app.js') }}"></script>

  {{-- <script src="js/app.js?v=1239283"></script> --}}

  <script>
    //偵測黑暗模式
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }

    // Whenever the user explicitly chooses light mode
    localStorage.theme = 'light'

    // Whenever the user explicitly chooses dark mode
    localStorage.theme = 'dark'

    // Whenever the user explicitly chooses to respect the OS preference
    localStorage.removeItem('theme')

    const navbar = new Vue({ 
        el: '#nav-bar', 
    }); 
    const IgLotteryForm = new Vue({ 
        el: '#IgLotteryForm', 
    });
    const CommentTable = new Vue({ 
        el: '#CommentTable', 
    });
    const Bg = new Vue({ 
        el: '#Bg', 
    });


  </script>


</body>

</html>