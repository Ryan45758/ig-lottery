﻿import { jsPDF } from "jspdf"
var callAddFont = function () {
this.addFileToVFS('pdfFont-normal.ttf', font);
this.addFont('pdfFont-normal.ttf', 'pdfFont', 'normal');
};
jsPDF.API.events.push(['addFonts', callAddFont])