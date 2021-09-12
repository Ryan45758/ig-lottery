<template>
  <div class="container mx-auto px-4 py-4 sm:px-8 md:w-9/12">
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :is-full-page="fullPage"
      :color="'#D200D2'"
      :loader="'dots'"
      :lock-scroll="true"
      :background-color="'#D6D1D1'"
      :width="180"
      :height="170"
    ></loading>
    <div
      class="
        mx-auto
        px-6
        py-12
        bg-white
        border-0
        shadow-lg
        sm:rounded-3xl
        dark:bg-gray-800
        rounded-lg
      "
    >
      <h1 class="text-2xl font-bold mb-8 dark:text-gray-100">
        Instagram Lottery
      </h1>
      <form id="form" novalidate autocomplete="off">
        <!-- ig抽獎連結start -->
        <div class="relative z-0 w-full mb-5">
          <input
            type="text"
            name="name"
            placeholder=" "
            required
            class="
              pt-3
              pb-2
              block
              w-full
              px-0
              mt-0
              bg-transparent
              border-0 border-b-2
              appearance-none
              focus:outline-none
              focus:ring-0
              focus:border-black
              border-gray-200
              dark:border-gray-400
              dark:focus:border-gray-200
              dark:text-gray-100
            "
            v-model="tmpUrl"
            v-on:keydown.enter="btnOnClickAjax"
          />
          <label
            for="name"
            class="
              absolute
              duration-300
              top-3
              -z-1
              origin-0
              text-gray-500
              dark:text-gray-400
            "
            >IG抽獎連結</label
          >
          <span
            class="text-sm text-red-600 dark:text-red-300"
            id="error"
            v-bind:class="{ hidden: urlErrorSpan }"
            >{{ urlErrorSpanMessage }}</span
          >
        </div>
        <!-- ig抽獎連結end -->

        <!-- ig留言限制start -->
        <transition name="fade">
          <div class="relative z-0 w-full mb-5" v-if="showLimitComment">
            <input
              type="text"
              name="limmitComment"
              placeholder=" "
              required
              class="
                pt-3
                pb-2
                block
                w-full
                px-0
                mt-0
                bg-transparent
                border-0 border-b-2
                appearance-none
                focus:outline-none
                focus:ring-0
                focus:border-black
                border-gray-200
                dark:border-gray-400
                dark:focus:border-gray-200
                dark:text-gray-100
              "
              v-model="limitCommentForm"
            />
            <label
              for="limmitComment"
              class="
                absolute
                duration-300
                top-3
                -z-1
                origin-0
                text-gray-500
                dark:text-gray-400
              "
              >限制留言格式</label
            >
            <span
              class="text-sm text-red-600 dark:text-red-300"
              id="error"
              v-bind:class="{ hidden: limitCommentErrorSpan }"
              >{{ limitCommentErrorSpanMessage }}</span
            >
          </div>
        </transition>
        <!-- ig留言限制end -->

        <!-- datime start -->
        <transition name="fade">
          <div v-if="showDateTime">
            <section>
              <date-picker
                v-model="dateTime"
                type="datetime"
                placeholder="點擊填入時間"
                value-type="timestamp"
                :show-time-panel="showTimePanel"
                :disabled-date="notAfterToday"
                @close="handleOpenChange"
                :editable="false"
                :input-attr="{
                  class:
                    'border-0 pt-3 pb-2 border-b-2 focus:outline-none focus:ring-0  focus:border-black border-gray-200 w-full bg-transparent  dark:border-gray-400 dark:focus:border-gray-200 dark:text-gray-100',
                }"
              >
                <template v-slot:footer>
                  <button class="mx-btn mx-btn-text" @click="toggleTimePanel">
                    {{ showTimePanel ? "select date" : "select time" }}
                  </button>
                </template>
              </date-picker>
              <span
                class="text-sm text-red-600 dark:text-red-300"
                id="error"
                v-bind:class="{ hidden: dateTimeErrorSpan }"
                >{{ dateTimeErrorSpanMessage }}</span
              >
            </section>
          </div>
        </transition>
        <!--datetime end  -->

        <!-- range slider start-->
        <!-- 標記人數 -->
        <div>
          <vue-slider
            v-model="markPeopleCountSlider"
            :min="markMin"
            :max="markMax"
            :tooltip="errorMarkMsg ? 'none' : 'active'"
            @error="errorMark"
            @change="clearMarkErrorMsg"
            class="mt-11"
            :railStyle="'{background-color: coral !important; }'"
          ></vue-slider>
          <div class="box mt-3 dark:text-gray-400">
            <span
              ><i class="fas fa-triangle text-gray-200"></i> 標記人數:
            </span>
            <input
              v-model="markPeopleCountSlider"
              @input="clearMarkErrorMsg"
              class="
                border
                focus:outline-none
                rounded-lg
                pl-2
                dark:bg-gray-800
                dark:text-gray-400
              "
            />
            <span
              style="margin-left: 20px"
              class="dark:text-red-300 text-red-600"
              >{{ errorMarkMsg }}</span
            >
          </div>
        </div>
        <!-- 抽獎人數 -->
        <div>
          <vue-slider
            v-model="lotteryValue"
            :min="lotteryMin"
            :max="lotteryMax"
            :tooltip="errorLotteryMsg ? 'none' : 'active'"
            @error="errorLottery"
            @change="clearLotteryErrorMsg"
            class="mt-11"
          ></vue-slider>
          <div class="box mt-3 dark:text-gray-400">
            <span
              ><i class="fas fa-triangle text-gray-200"></i> 抽獎人數:
            </span>
            <input
              v-model="lotteryValue"
              @input="clearLotteryErrorMsg"
              class="
                border
                focus:outline-none
                rounded-lg
                pl-2
                dark:bg-gray-800
                dark:text-gray-400
              "
            />
            <span
              style="margin-left: 20px"
              class="dark:text-red-300 text-red-600"
              >{{ errorLotteryMsg }}</span
            >
          </div>
        </div>

        <!-- range slider end -->

        <!-- toggle button start -->
        <div class="grid grid-cols-2 md:grid-cols-2 mt-12">
          <div>
            <!-- Toggle A -->
            <div class="flex items-center w-full mb-12">
              <label for="toggleA" class="flex items-center cursor-pointer">
                <!-- toggle -->
                <div class="relative">
                  <!-- input -->
                  <input
                    type="checkbox"
                    id="toggleA"
                    class="sr-only"
                    v-on:click="ShowLimitComment"
                  />
                  <!-- line -->
                  <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                  <!-- dot -->
                  <div
                    class="
                      dot
                      absolute
                      left-1
                      top-1
                      bg-white
                      w-6
                      h-6
                      rounded-full
                      transition
                    "
                  ></div>
                </div>
                <!-- label -->
                <div class="ml-3 text-gray-700 font-medium dark:text-gray-400">
                  限制格式
                </div>
              </label>
            </div>
          </div>
          <div>
            <!-- Toggle B -->
            <div class="flex items-center w-full mb-12">
              <label for="toggleB" class="flex items-center cursor-pointer">
                <!-- toggle -->
                <div class="relative">
                  <!-- input -->
                  <input
                    type="checkbox"
                    id="toggleB"
                    class="sr-only"
                    v-model="showDateTime"
                    v-on:click="ShowDateTime"
                  />
                  <!-- line -->
                  <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                  <!-- dot -->
                  <div
                    class="
                      dot
                      absolute
                      left-1
                      top-1
                      bg-white
                      w-6
                      h-6
                      rounded-full
                      transition
                    "
                  ></div>
                </div>
                <!-- label -->
                <div class="ml-3 text-gray-700 font-medium dark:text-gray-400">
                  限制時間
                </div>
              </label>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-2">
          <!-- Toggle C -->
          <div class="flex items-center w-full mb-12">
            <label for="toggleC" class="flex items-center cursor-pointer">
              <!-- toggle -->
              <div class="relative">
                <!-- input -->
                <input
                  type="checkbox"
                  id="toggleC"
                  class="sr-only"
                  v-on:click="BtCanRepeatComment"
                  v-model="btCanRepeatComment"
                />
                <!-- line -->
                <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                <!-- dot -->
                <div
                  class="
                    dot
                    absolute
                    left-1
                    top-1
                    bg-white
                    w-6
                    h-6
                    rounded-full
                    transition
                  "
                ></div>
              </div>
              <!-- label -->
              <div class="ml-3 text-gray-700 font-medium dark:text-gray-400">
                不可重複
              </div>
            </label>
          </div>

          <!-- Toggle D -->
          <div class="flex items-center w-full mb-12">
            <label for="toggleD" class="flex items-center cursor-pointer">
              <!-- toggle -->
              <div class="relative">
                <!-- input -->
                <input
                  type="checkbox"
                  id="toggleD"
                  class="sr-only"
                  v-on:click="BtExcludeMe"
                  v-model="btExcludeMe"
                />
                <!-- line -->
                <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                <!-- dot -->
                <div
                  class="
                    dot
                    absolute
                    left-1
                    top-1
                    bg-white
                    w-6
                    h-6
                    rounded-full
                    transition
                  "
                ></div>
              </div>
              <!-- label -->
              <div class="ml-3 text-gray-700 font-medium dark:text-gray-400">
                排除自己
              </div>
            </label>
          </div>
        </div>
        <!-- toggle button end -->

        <button
          id="button"
          type="button"
          class="
            w-full
            px-6
            py-3
            mt-3
            text-lg text-white
            transition-all
            duration-150
            ease-linear
            rounded-lg
            shadow
            outline-none
            focus:outline-none
          "
          v-bind:class="{
            'dark:bg-gray-700': disableSendBt,
            'dark:bg-gray-400': !disableSendBt,
            'bg-gray-200': disableSendBt,
            'bg-pink-500': !disableSendBt,
            'hover:bg-pink-600': !disableSendBt,
            'hover:shadow-lg': !disableSendBt,
            'cursor-not-allowed': disableSendBt,
          }"
          v-on:click="btnOnClickAjax"
          :disabled="disableSendBt"
        >
          開始抽獎！
        </button>
      </form>
    </div>
  </div>
</template> 


<script>
import eventBus from "../eventBus";
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/antd.css";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";

const ERROR_TYPE = {
  VALUE: 1,
  INTERVAL: 2,
  MIN: 3,
  MAX: 4,
  ORDER: 5,
};
export default {
  components: {
    VueSlider,
    DatePicker,
    Loading,
  },
  props: [
    "editable",
    "input-attr",
    "color",
    "loader",
    "blur",
    "lock-scroll",
    "background-color",
    "width",
    "height",
    "railStyle",
  ],
  data: function () {
    return {
      //-------loading動畫參數
      isLoading: false,
      fullPage: true,
      //----------------------
      value: { a: 2, b: 3 },
      showTimePanel: false,
      //---------預設API參數
      url: "",
      peopleCount: 1,
      canRepeatComment: false,
      limitComment: false,
      limitTime: false,
      markPeopleCount: 0,
      excludeMe: true,

      //----------------

      //----------表單驗證URL
      tmpUrl: "",
      urlErrorSpan: false, //判斷span要不要隱藏
      urlErrorSpanMessage: "此欄位為必填",
      correctUrl: false, //判斷連結是否正確

      limitCommentForm: "",
      limitCommentErrorSpan: false,
      limitCommentErrorSpanMessage: "填寫或隱藏此欄位",
      correctLimitComment: true,

      dateTime: null,
      dateTimeErrorSpan: false,
      dateTimeErrorSpanMessage: "此欄位為必填",
      correctDateTime: true,
      clearFlag: false,
      limitCommentFormClearFlag: false,
      //---------------------

      //----------四顆按紐
      showDateTime: false, //是否彈出時間欄位
      showLimitComment: false, //是否彈出留言欄位

      btExcludeMe: true,
      btCanRepeatComment: true,
      //-------------------

      //---------slider參數
      markPeopleCountSlider: 0,
      markMin: 0,
      markMax: 100,
      errorMarkMsg: "",
      correctMarkPeopleCountSlider: true,

      lotteryValue: 1,
      lotteryMin: 1,
      lotteryMax: 100,
      errorLotteryMsg: "",
      correctLotterySlider: true,
      //--------------------

      //----------------送出按紐
      //correctAll: [false, true, true, true, true],
      correctAll: { a: false, b: true, c: true, d: true, e: true },
      disableSendBt: true,
      //---------------------
    };
  },
  watch: {
    tmpUrl: function (val) {
      var urlSplit = val.split("/");
      var regex = /^[\d|a-zA-Z_-]+$/;

      if (val == "") {
        this.url = "";
        this.correctUrl = false;
        this.urlErrorSpan = false;
        this.urlErrorSpanMessage = "此欄位為必填";
      } else if (
        urlSplit[0] != "https:" ||
        urlSplit[1] != "" ||
        urlSplit[2] != "www.instagram.com" ||
        urlSplit[3] != "p" ||
        urlSplit[4] == "" ||
        urlSplit.length <= 4 ||
        !regex.test(urlSplit[4])
      ) {
        this.url = "";
        this.urlErrorSpan = false;
        this.correctUrl = false;
        this.urlErrorSpanMessage = "連結不符合 IG 貼文格式";
      } else {
        this.url = val;
        this.correctUrl = true;
        this.urlErrorSpan = true;
      }
    },
    markPeopleCountSlider: function (val) {
      if (val === "") {
        this.correctMarkPeopleCountSlider = false;
        this.errorMarkMsg = "範圍為 0 ~ 100 呦！！預設為 0 人";
      } else if (val >= 0 && val <= 100) {
        this.correctMarkPeopleCountSlider = true;
        this.markPeopleCount = val;
      }
    },
    lotteryValue: function (val) {
      if (val === "") {
        this.correctLotterySlider = false;
        this.errorLotteryMsg = "範圍為 1 ~ 100 呦！！預設為 1 人";
      } else if (val >= 1 && val <= 100) {
        this.correctLotterySlider = true;
        this.peopleCount = val;
      }
    },
    limitCommentForm: function (val) {
      if (val != "") {
        this.limitComment = val;
        this.correctLimitComment = true;
        this.limitCommentErrorSpan = true;
      } else {
        if ((this.limitCommentFormClearFlag = true)) {
          this.limitComment = false;
          this.correctLimitComment = true;
          this.limitCommentErrorSpan = false;
          this.limitCommentFormClearFlag = false;
        } else {
          this.limitComment = false;
          this.correctLimitComment = false;
          this.limitCommentErrorSpan = false;
        }
      }
    },
    dateTime: function (val) {
      if (val != null) {
        this.limitTime = this.dateTime / 1000;
        this.dateTimeErrorSpan = true;
        this.correctDateTime = true;
      } else {
        this.limitTime = false;
        if (this.clearFlag == true) {
          this.correctDateTime = true;
          this.dateTimeErrorSpan = false;
          this.clearFlag = false;
        } else {
          this.correctDateTime = false;
          this.dateTimeErrorSpan = false;
        }
      }
    },
    correctUrl: function (val) {
      if (val == true) {
        this.correctAll.a = true;
      } else {
        this.correctAll.a = false;
      }
    },
    correctLimitComment: function (val) {
      if (val == true) {
        this.correctAll.b = true;
      } else {
        this.correctAll.b = false;
      }
    },
    correctDateTime: function (val) {
      if (val == true) {
        this.correctAll.c = true;
      } else {
        this.correctAll.c = false;
      }
    },
    correctMarkPeopleCountSlider: function (val) {
      if (val == true) {
        this.correctAll.d = true;
      } else {
        this.correctAll.d = false;
      }
    },
    correctLotterySlider: function (val) {
      if (val == true) {
        this.correctAll.e = true;
      } else {
        this.correctAll.e = false;
      }
    },
    correctAll: {
      handler: function (val, oldVal) {
        if (
          this.correctAll.a &&
          this.correctAll.b &&
          this.correctAll.c &&
          this.correctAll.d &&
          this.correctAll.e
        ) {
          this.disableSendBt = false;
        } else {
          this.disableSendBt = true;
        }
      },
      deep: true,
      immediate: true,
    },
  },
  methods: {
    ShowDateTime() {
      this.value.a = 3;
      this.showDateTime = !this.showDateTime;
      if (this.showDateTime == false) {
        this.correctDateTime = true;
        this.limitTime = false;
        if (this.dateTime != null) {
          this.dateTime = null; //清成null
          this.clearFlag = true; // clearFlag設true
        }
      } else {
        this.correctDateTime = false;
      }
    },
    ShowLimitComment() {
      //切換開關
      this.showLimitComment = !this.showLimitComment;
      //關閉開關，留言限制關掉
      if (this.showLimitComment == false) {
        this.limitComment = false;
        if (this.limitCommentForm != "") {
          this.limitCommentForm = "";
          this.limitCommentFormClearFlag = true;
        }
        this.correctLimitComment = true;
      } else {
        this.correctLimitComment = false;
      }
    },
    BtExcludeMe() {
      this.btExcludeMe = !this.btExcludeMe;
      this.excludeMe = this.btExcludeMe;
    },
    BtCanRepeatComment() {
      this.btCanRepeatComment = !this.btCanRepeatComment;
      this.canRepeatComment = !this.btCanRepeatComment;
    },
    errorMark(type, msg) {
      switch (type) {
        case ERROR_TYPE.MIN:
          break;
        case ERROR_TYPE.MAX:
          break;
        case ERROR_TYPE.VALUE:
          break;
      }
      this.correctMarkPeopleCountSlider = false;
      this.markPeopleCount = 0;
      this.errorMarkMsg = "範圍為 0 ~ 100 呦！！預設為 0 人";
    },
    clearMarkErrorMsg() {
      this.errorMarkMsg = "";
    },

    //Lottery slider error setting
    errorLottery(type, msg) {
      switch (type) {
        case ERROR_TYPE.MIN:
          break;
        case ERROR_TYPE.MAX:
          break;
        case ERROR_TYPE.VALUE:
          break;
      }
      this.correctLotterySlider = false;
      this.peopleCount = 1;
      this.errorLotteryMsg = "範圍為 1 ~ 100 呦！！預設為 1 人";
    },
    clearLotteryErrorMsg() {
      this.errorLotteryMsg = "";
    },
    toggleTimePanel() {
      this.showTimePanel = !this.showTimePanel;
    },
    handleOpenChange() {
      this.showTimePanel = false;
    },
    notAfterToday(date) {
      return date > new Date(new Date().setHours(0, 0, 0, 0));
    },
    btnOnClickAjax() {
      if (this.disableSendBt == false) {
        this.isLoading = true;
        var loading = this.isLoading;
        axios
          .post(location.toString()+"api/lottery", {
            url: this.url,
            peopleCount: this.peopleCount,
            canRepeatComment: this.canRepeatComment,
            limitComment: this.limitComment,
            limitTime: this.limitTime,
            markPeopleCount: this.markPeopleCount,
            excludeMe: this.excludeMe,
          })
          .then(function (response) {
            eventBus.$emit("ajaxResult", response); // 將ajax結果傳入commentTable
          })
          .catch(function (error) {
            alert(
              "哦哦！網站掛掉了，放心，我已經收到掛掉的訊息了，幫我按確定就可以了，稍後再試，感謝你"
            );
            // axios
            //   .post("https://iglottery.r-dap.com/api/sendMail", {
            //   })
            //   .then(function (response) {
            //   })
            //   .catch(function (error) {
            //   })
            //   .finally(() => {
            //   });
          })
          .finally(() => {
            this.isLoading = false;
          });
      }
    },
  },
  mounted() {
    //監聽loading動畫是否持續
    eventBus.$on("loadingResult", (response) => {
      this.isLoading = response;
    });
    document.addEventListener("keydown", (e) => {
      if (e.keyCode == 108 && !this.disableSendBt) {
        btnOnClickAjax();
      }
    });
  },
  beforeDestroy() {
    // removing eventBus listener
    eventBus.$off("loadingResult");
  },
};
</script>

<style>
.-z-1 {
  z-index: -1;
}

.origin-0 {
  transform-origin: 0%;
}

input:focus ~ label,
input:not(:placeholder-shown) ~ label,
textarea:focus ~ label,
textarea:not(:placeholder-shown) ~ label,
select:focus ~ label,
select:not([value=""]):valid ~ label {
  /* @apply transform; scale-75; -translate-y-6; */
  --tw-translate-x: 0;
  --tw-translate-y: 0;
  --tw-rotate: 0;
  --tw-skew-x: 0;
  --tw-skew-y: 0;
  transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y))
    rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y))
    scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
  --tw-scale-x: 0.75;
  --tw-scale-y: 0.75;
  --tw-translate-y: -1.5rem;
}

input:focus ~ label,
select:focus ~ label {
  /* @apply text-black; left-0; */
  --tw-text-opacity: 1;
  color: rgba(0, 0, 0, var(--tw-text-opacity));
  left: 0px;
}

/* Toggle A  */
input:checked ~ .dot {
  transform: translateX(100%);
  background-color: #48bb78;
}

/* Toggle B */
input:checked ~ .dot {
  transform: translateX(100%);
  background-color: #48bb78;
}

/* 淡入淡出 start */
.fade-enter {
  opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s;
}
.fade-leave-to {
  opacity: 0;
}
/* 淡入淡出 end */

/* 變更slider顏色 */
.vue-slider-process {
  background-color: #48bb78 !important;
}
.vue-slider-rail {
  --tw-bg-opacity: 1;
  background-color: rgba(209, 213, 219, var(--tw-bg-opacity)) !important;
}
/* 變更月曆CSS */
.mx-datepicker {
  width: 100%;
}
</style>