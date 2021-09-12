<template>
  <div
    class="
      bg-white
      w-full
      flex
      relative
      justify-between
      items-center
      mx-auto
      px-8
      h-20
      dark:bg-gray-800
    "
  >
    <!-- logo -->
    <div class="inline-flex">
      <a class="_o6689fn" href="/">
        <div class="dark:text-gray-300">R-DAP</div>
      </a>
    </div>

    <!-- end logo -->

    <!-- login -->
    <div class="flex-initial">
      <div class="flex justify-end items-center relative">
        <div class="flex mr-4 items-center">
          <!-- <a
            class="inline-block py-2 px-3 hover:bg-gray-200 rounded-full"
            href="#"
          >
            <div
              class="
                flex
                items-center
                relative
                cursor-pointer
                whitespace-nowrap
                dark:text-gray-300
              "
            >
              English
            </div>
          </a> -->
          <div class="block relative">
            <div class="flex items-center h-5">
              <div class="_xpkakx dark:text-gray-300">
                <!-- <button
                  type="button"
                  aria-label="Color Mode"
                  class="
                    flex
                    justify-center
                    p-2
                    text-gray-500
                    transition
                    duration-150
                    ease-in-out
                    bg-gray-100
                    border border-transparent
                    rounded-md
                    lg:bg-white
                    lg:dark:bg-gray-900
                    dark:text-gray-200
                    dark:bg-gray-800
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                    hover:text-gray-700
                    focus:outline-none
                    focus:bg-gray-50
                    dark:focus:bg-gray-700
                    active:bg-gray-50
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </button> -->
                <button
                  type="button"
                  aria-label="Color Mode"
                  class="
                    flex
                    justify-center
                    p-2
                    text-gray-500
                    transition
                    duration-150
                    ease-in-out
                    border border-transparent
                    rounded-md
                    lg:bg-white
                    lg:dark:bg-gray-900
                    dark:text-gray-300
                    dark:bg-gray-800
                    hover:bg-gray-50
                    dark:hover:bg-gray-700
                    hover:text-gray-700
                    focus:outline-none
                    focus:bg-gray-50
                    dark:focus:bg-gray-700
                    active:bg-gray-50
                  "
                  v-on:click="darkMode"
                >
                  <!-- 太陽 -->
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    class="w-5 h-5"
                    v-if="!darkmode"
                  >
                    <path
                      d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                  <!-- 太陽 -->
                  <!-- 月亮 -->
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    class="w-5 h-5 transform -rotate-90"
                    v-if="darkmode"
                  >
                    <path
                      d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
                    ></path>
                  </svg>
                  <!-- 月亮 -->
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="block">
          <div class="inline relative">
            <div class="flex items-center">
              <button class="mr-2" aria-label="Open Menu" @click="drawer">
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  class="w-8 h-8 dark:text-gray-300 text-gray-500"
                >
                  <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
              </button>
            </div>

            <transition
              enter-class="opacity-0"
              enter-active-class="ease-out transition-medium"
              enter-to-class="opacity-100"
              leave-class="opacity-100"
              leave-active-class="ease-out transition-medium"
              leave-to-class="opacity-0"
            >
              <div
                @keydown.esc="isOpen = false"
                v-show="isOpen"
                class="z-10 fixed inset-0 transition-opacity"
              >
                <div
                  @click="isOpen = false"
                  class="absolute inset-0 bg-black opacity-50"
                  tabindex="0"
                ></div>
              </div>
            </transition>
            <aside
              class="
                transform
                inset-y-0
                right-0
                w-64
                bg-white
                fixed
                h-full
                overflow-auto
                ease-in-out
                transition-all
                duration-300
                z-30
                dark:bg-gray-800
                dark:text-gray-300
              "
              :class="isOpen ? 'translate-x-0' : 'translate-x-full'"
            >
              <span
                @click="isOpen = false"
                class="flex w-full items-center p-4 border-b dark:border-gray-400"
              >
                <img
                  :src="'../img/R-DAP.png'"
                  alt="Logo"
                  class="h-auto w-32 mx-auto"
                />
              </span>
              <!-- <span
                @click="isOpen = false"
                class="
                  flex
                  items-center
                  p-4
                  hover:bg-indigo-500
                  hover:text-white
                "
                ><span class="mr-2">
                  <svg
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    class="w-6 h-6"
                  >
                    <path
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    ></path>
                  </svg>
                </span>
                <span>Home</span></span
              > -->
              <span
                @click="isOpen = false"
                class="flex items-center p-4 hover:bg-gray-200 dark:hover:bg-gray-500"
                ><span class="mr-2">
                  <img :src="'../img/globe.svg'" class="w-6 h-6" v-if="!darkmode"/>
                  <img :src="'../img/www.svg'" class="w-6 h-6" v-if="darkmode"/>
                </span>
                <span class="dark:text-gray-300">網站累計瀏覽: {{visitedCount}} 人</span></span
              >
              <!-- <!-- <span
                @click="isOpen = false"
                class="
                  flex
                  items-center
                  p-4
                  hover:bg-indigo-500
                  hover:text-white
                "
                ><span class="mr-2">
                  <svg
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    class="w-6 h-6"
                  >
                    <path
                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"
                    ></path>
                  </svg>
                </span>
                <span>Wishlist</span></span
              > -->
              <span
                @click="isOpen = false"
                class="flex items-center p-4 hover:bg-gray-200 dark:hover:bg-gray-500"
                ><span class="mr-2">
                  <img :src="'../img/payment.svg'" class="w-6 h-6" v-if="!darkmode"/>
                  <img :src="'../img/profit.svg'" class="w-6 h-6" v-if="darkmode"/>
                </span>
                <span class="dark:text-gray-300">累積受益人數: {{benefitCount}} 人</span></span
              >
              <a href="mailto:ryan45758@gmail.com">
                <span
                  @click="isOpen = false"
                  class="flex items-center p-4 hover:bg-gray-200 cursor-pointer dark:hover:bg-gray-500"
                  ><span class="mr-2">
                    <img :src="'../img/envelope.svg'" class="w-6 h-6" v-if="!darkmode"/>
                    <img :src="'../img/open-email.svg'" class="w-6 h-6" v-if="darkmode"/>
                  </span>
                  <span class="dark:text-gray-300">合作或Bug請聯絡我</br>ryan45758@gmail.com</span></span
                >
              </a>

              <div class="fixed bottom-0 w-full">
                <a href="mailto:ryan45758@gmail.com"
                  class="
                    flex
                    items-center
                    p-4
                    text-white
                    bg-blue-500
                    hover:bg-blue-600
                    w-full
                  "
                >
                  <!-- <svg
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    class="h-6 w-6 mr-2"
                  >
                    <path
                      d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"
                    ></path>
                  </svg> -->
                  <img :src="'../img/info.svg'" class="h-6 w-6 mr-2"/>
                  <span>網站試營運，不能動請立刻通知我，一直掛掉的話，就不幹了，直接開源，IG很嚴格</span>
                </a>
                <a
                  rel="noopener"
                  class="flex items-center p-4 bg-gray-700 text-white"
                  href="https://www.paypal.me/ryan45758"
                  target="_blank"
                >
                  <img
                    class="mr-2 h-8 w-auto"
                    :src="'../img/bmc.svg'"
                    alt="Buy Me Coffee"
                  />
                  <p>
                    <span class="font-bold">幫助我買杯咖啡</span>
                    <br />
                    <span class="text-sm text-white"
                      >讓伺服器能繼續活著🥺🥺</span
                    >
                  </p>
                </a>
              </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
    <!-- end login -->
  </div>
</template>

<script>
import { Column } from "jspdf-autotable";
export default {
  props: ['visitedCount','benefitCount'],
  data() {
    return {
      isOpen: false,
      darkmode: false,
    };
  },
  methods: {
    drawer() {
      this.isOpen = !this.isOpen;
    },
    darkMode() {
      this.darkmode = !this.darkmode;
      if (this.darkmode === true) {
        document.documentElement.classList.add("dark");
      } else {
        document.documentElement.classList.remove("dark");
      }
    },
  },
  watch: {
    isOpen: {
      immediate: true,
      handler(isOpen) {
        if (process.client) {
          if (isOpen) document.body.style.setProperty("overflow", "hidden");
          else document.body.style.removeProperty("overflow");
        }
      },
    },
  },
  created: function () {
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
      this.darkmode = true;
    }
  },
  mounted() {
    document.addEventListener("keydown", (e) => {
      if (e.keyCode == 27 && this.isOpen) this.isOpen = false;
    });
  },
};
</script>