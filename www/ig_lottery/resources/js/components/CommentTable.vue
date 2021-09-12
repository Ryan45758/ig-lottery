<template>
  <div class="md:w-9/12 mx-auto">
    <div class="h-20" ref="comment-top"></div>
    <div class="container mx-auto px-4 sm:px-8">
      <div class="pt-8">
        <div class="flex">
          <div class="text-2xl font-semibold leading-tight dark:text-gray-100 my-auto">恭喜中獎 {{ajaxResult.data.lottery_result.length}} 人</div>
         <!-- This example requires Tailwind CSS v2.0+ -->
          <div class="relative inline-block text-left ml-auto">
            <div>
              <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 dark:bg-gray-600 dark:text-gray-300" id="menu-button" aria-expanded="true" aria-haspopup="true" v-on:click="ShowDlBt">
                儲存檔案
                <!-- Heroicon name: solid/chevron-down -->
                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <!--
              Dropdown menu, show/hide based on menu state.

              Entering: "transition ease-out duration-100"
                From: "transform opacity-0 scale-95"
                To: "transform opacity-100 scale-100"
              Leaving: "transition ease-in duration-75"
                From: "transform opacity-100 scale-100"
                To: "transform opacity-0 scale-95"
            -->
            <div class="dark:bg-gray-600 origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" v-if="showDlBt">
              <div class="py-1" role="none">
                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                <div class="text-gray-700 block px-4 py-2 text-sm dark:hover:bg-gray-500 cursor-pointer" role="menuitem" tabindex="-1" id="menu-item-0"><download-csv
                class   = "dark:text-gray-300"
                :data   = "json_data"
                name    = "IG抽獎結果.csv">匯出成CSV
              </download-csv></div>
                <div class="dark:text-gray-300 text-gray-700 block px-4 py-2 text-sm dark:hover:bg-gray-500 cursor-pointer" role="menuitem" tabindex="-1" id="menu-item-1" v-on:click="DlPdf">匯出成PDF</div>
                
              </div>
            </div>
          </div>
          <!-- <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center ml-auto">
              <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
              <span><download-csv
                class   = ""
                :data   = "json_data"
                name    = "IG抽獎結果.csv">
                匯出CSV
              </download-csv></span>
            </button> -->
        </div>

        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
          <div
            class="inline-block min-w-full shadow rounded-lg overflow-hidden"
          >
            <table class="min-w-full leading-normal">
              <thead>
                <tr>
                  <th
                    class="
                      px-5
                      py-3
                      border-b-2 border-gray-200
                      bg-gray-100
                      text-left text-xs
                      font-semibold
                      text-gray-600
                      uppercase
                      tracking-wider
                      dark:text-gray-100
                      dark:bg-gray-900
                      dark:border-gray-500
                    "
                  >
                    用戶
                  </th>
                  <th
                    class="
                      px-5
                      py-3
                      border-b-2 border-gray-200
                      bg-gray-100
                      text-left text-xs
                      font-semibold
                      text-gray-600
                      uppercase
                      tracking-wider
                      dark:text-gray-100
                      dark:bg-gray-900
                      dark:border-gray-500
                    "
                  >
                    留言
                  </th>
                  
                </tr>
              </thead>
              <tbody>
                <tr v-for="comment in ajaxResult.data.lottery_result">
                  <td
                    class="px-5 py-5 border-b border-gray-200 bg-white text-sm dark:bg-gray-800 dark:border-gray-500"
                  >
                  <p>
                    <div class="flex items-center">
                      <div class="flex-shrink-0 w-10 h-10">
                        <img
                          class="w-full h-full rounded-full"
                          v-bind:src="comment.header"
                          alt=""
                        />
                      </div>
                      <div class="ml-3">
                        <p class="text-gray-900 dark:text-gray-100">
                          <a
                            v-bind:href="
                              'https://www.instagram.com/' +
                              comment.userName +
                              '/'
                            "
                            target="_blank"
                          >
                            {{ comment.userName }}
                          </a>
                        </p>
                      </div>
                    </div>
                  </p>
                  </td>
                  <td
                    class="px-5 py-5 border-b border-gray-200 bg-white text-sm dark:bg-gray-800 dark:border-gray-500"
                  >
                    <p class="text-gray-900 whitespace-no-wrap dark:text-gray-100">
                      {{ comment.content }}
                    </p>
                  </td>
                 
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="container mx-auto px-4 sm:px-8">
      <div class="py-8">
        <div>
          <h2 class="text-2xl font-semibold leading-tight dark:text-gray-100">符合的留言 {{ajaxResult.data.data.length}} 則</h2>
        </div>

        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
          <div
            class="inline-block min-w-full shadow rounded-lg overflow-hidden"
          >
            <table class="min-w-full leading-normal"  id="my-table">
              <thead>
                <tr>
                  <th
                    class="
                      px-5
                      py-3
                      border-b-2 border-gray-200
                      bg-gray-100
                      text-left text-xs
                      font-semibold
                      text-gray-600
                      uppercase
                      tracking-wider
                      dark:text-gray-100
                      dark:bg-gray-900
                      dark:border-gray-500
                    "
                  >
                    用戶
                  </th>
                  <th
                    class="
                      px-5
                      py-3
                      border-b-2 border-gray-200
                      bg-gray-100
                      text-left text-xs
                      font-semibold
                      text-gray-600
                      uppercase
                      tracking-wider
                      dark:text-gray-100
                      dark:bg-gray-900
                      dark:border-gray-500
                    "
                  >
                    留言
                  </th>
                  
                </tr>
              </thead>
              <tbody>
                <tr v-for="comment in ajaxResult.data.data">
                  <td
                    class="px-5 py-5 border-b border-gray-200 bg-white text-sm dark:bg-gray-800 dark:border-gray-500"
                  >
                  <p>
                    <div class="flex items-center">
                      <div class="flex-shrink-0 w-10 h-10">
                        <img
                          class="w-full h-full rounded-full"
                          v-bind:src="comment.header"
                          alt=""
                        />
                      </div>
                      <div class="ml-3">
                        <p class="text-gray-900 dark:text-gray-100">
                          <a
                            v-bind:href="
                              'https://www.instagram.com/' +
                              comment.userName +
                              '/'
                            "
                            target="_blank"
                          >
                            {{ comment.userName }}
                          </a>
                        </p>
                      </div>
                    </div>
                  </p>
                  </td>
                  <td
                    class="px-5 py-5 border-b border-gray-200 bg-white text-sm dark:bg-gray-800 dark:border-gray-500"
                  >
                    <p class="text-gray-900 whitespace-no-wrap dark:text-gray-100">
                      {{ comment.content }}
                    </p>
                  </td>
                 
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import eventBus from "../eventBus";
import Vue from "vue";
import JsonCSV from "vue-json-csv";
import jsPDF from "jspdf";
import "jspdf-autotable";
import "../microsoftfont-normal";
Vue.component("downloadCsv", JsonCSV);
export default {
  components: {
    IgLotteryForm,
  },
  data: function () {
    return {
      showDlBt: false,
      ajaxResult: null,
      imgUrl: "",
      json_data: [],
      pdf_data: [],
    };
  },
  updated() {
    this.$refs["comment-top"].scrollIntoView({ behavior: "smooth" });
    //載入完畢傳達訊息給iglotterform loading畫面
    eventBus.$emit("loadingResult", false);
  },
  mounted() {
    eventBus.$on("ajaxResult", (response) => {
      this.ajaxResult = response;
      this.json_data = response.data.user_data_csv;
    });
  },
  beforeDestroy() {
    // removing eventBus listener
    eventBus.$off("ajaxResult");
  },
  watch: {
    ajaxResult: function (val) {
      var data = [];
      val.data.user_data_csv.forEach(function (item, index, array) {
        //console.log(index);
        data.push([index, item.用戶, item.留言, item.建立時間]);
        //this.pdf_data.push(index);
      });
      this.pdf_data = data;
    },
  },

  methods: {
    ShowDlBt() {
      this.showDlBt = !this.showDlBt;
    },
    DlCsv() {},
    DlPdf() {
      //----------------------PDF------------
      //初始化
      const doc = new jsPDF();
      //設置字體
      doc.setFont("microsoftfont");
      //設置內容
      doc.text("符合資格留言", 22, 22);
      doc.autoTable({
        head: [["ID", "用戶", "留言", "建立時間"]],
        body: this.pdf_data,
        styles: {
          font: "microsoftfont",
        },
        theme: "grid",
        headStyles: { minCellWidth: 20 },
      });
      //導出
      doc.save("table.pdf");
      //---------------------------------------
    },
  },
};
</script>
<style>
</style>