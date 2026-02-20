<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <div id="ember1820" class="ember-view">
        <div id="template-html-shadow-host" class="overflow-hidden">
            <template shadowrootmode="open">
                <style>
                    /* Reset css */
                    * {
                        box-sizing: border-box;
                    }

                    html,
                    body,
                    div,
                    span,
                    applet,
                    object,
                    iframe,
                    h1,
                    h2,
                    h3,
                    h4,
                    h5,
                    h6,
                    p,
                    blockquote,
                    pre,
                    a,
                    abbr,
                    acronym,
                    address,
                    big,
                    cite,
                    code,
                    del,
                    dfn,
                    em,
                    img,
                    ins,
                    kbd,
                    q,
                    s,
                    samp,
                    small,
                    strike,
                    strong,
                    sub,
                    sup,
                    tt,
                    var,
                    b,
                    u,
                    i,
                    center,
                    dl,
                    dt,
                    dd,
                    ol,
                    ul,
                    li,
                    fieldset,
                    form,
                    label,
                    legend,
                    table,
                    caption,
                    tbody,
                    tfoot,
                    thead,
                    tr,
                    th,
                    td,
                    article,
                    aside,
                    canvas,
                    details,
                    embed,
                    figure,
                    figcaption,
                    footer,
                    header,
                    hgroup,
                    menu,
                    nav,
                    output,
                    ruby,
                    section,
                    summary,
                    time,
                    mark,
                    audio,
                    video {
                        margin: 0;
                        padding: 0;
                        border: 0;
                        font-size: 100%;
                        font: inherit;
                    }

                    /* HTML5 display-role reset for older browsers */
                    article,
                    aside,
                    details,
                    figcaption,
                    figure,
                    footer,
                    header,
                    hgroup,
                    menu,
                    nav,
                    section {
                        display: block;
                    }

                    body {
                        line-height: 1;
                    }

                    ol,
                    ul {
                        list-style: none;
                    }

                    blockquote,
                    q {
                        quotes: none;
                    }

                    blockquote:before,
                    blockquote:after,
                    q:before,
                    q:after {
                        content: "";
                        content: none;
                    }

                    table {
                        border-collapse: collapse;
                        border-spacing: 0;
                    }

                    /* Flying saucer css */
                    html,
                    address,
                    blockquote,
                    body,
                    dd,
                    div,
                    dl,
                    dt,
                    fieldset,
                    form,
                    frame,
                    frameset,
                    h1,
                    h2,
                    h3,
                    h4,
                    h5,
                    h6,
                    noframes,
                    ol,
                    p,
                    ul,
                    center,
                    dir,
                    hr,
                    menu,
                    pre,
                    object {
                        display: block;
                    }

                    li {
                        display: list-item;
                    }

                    head,
                    script {
                        display: none;
                    }

                    body {
                        margin: 8px;
                    }

                    h1 {
                        font-size: 2em;
                        margin: 0.67em 0;
                    }

                    h2 {
                        font-size: 1.5em;
                        margin: 0.75em 0;
                    }

                    h3 {
                        font-size: 1.17em;
                        margin: 0.83em 0;
                    }

                    h4,
                    p,
                    blockquote,
                    ul,
                    fieldset,
                    ol,
                    dl,
                    dir,
                    menu {
                        margin: 1.12em 0;
                    }

                    h5 {
                        font-size: 0.83em;
                        margin: 1.5em 0;
                    }

                    h6 {
                        font-size: 0.75em;
                        margin: 1.67em 0;
                    }

                    h1,
                    h2,
                    h3,
                    h4,
                    h5,
                    h6,
                    b,
                    strong {
                        font-weight: bold;
                    }

                    blockquote {
                        margin-left: 40px;
                        margin-right: 40px;
                    }

                    i,
                    cite,
                    em,
                    var,
                    address {
                        font-style: italic;
                    }

                    pre,
                    tt,
                    code,
                    kbd,
                    samp {
                        font-family: monospace;
                    }

                    pre {
                        white-space: pre;
                    }

                    button,
                    textarea,
                    input,
                    select {
                        display: inline-block;
                        font-family: sans-serif;
                        font-size: 10pt;
                    }

                    big {
                        font-size: 1.17em;
                    }

                    small {
                        font-size: 0.83em;
                    }

                    s,
                    strike,
                    del {
                        text-decoration: line-through;
                    }

                    ol,
                    ul,
                    dir,
                    menu {
                        padding-left: 40px;
                    }

                    dd {
                        margin-left: 40px;
                    }

                    ul {
                        list-style-type: disc;
                    }

                    ol {
                        list-style-type: decimal;
                    }

                    ol ul,
                    ul ol,
                    ul ul,
                    ol ol {
                        margin-top: 0;
                        margin-bottom: 0;
                    }

                    u,
                    ins {
                        text-decoration: underline;
                    }

                    center {
                        text-align: center;
                    }

                    a:link {
                        cursor: pointer;
                    }

                    h5,
                    h6,
                    b,
                    strong {
                        font-weight: bold;
                    }

                    /* Match default behavior of Firefox and Opera */
                    pre {
                        margin: 1em 0;
                    }

                    /* caption inherits from table not table-outer */
                    caption {
                        display: table-caption;
                        text-align: center;
                    }

                    table[align="center"]>caption {
                        margin-left: auto;
                        margin-right: auto;
                    }

                    table[align="center"]>caption[align="left"] {
                        margin-right: 0;
                    }

                    table[align="center"]>caption[align="right"] {
                        margin-left: 0;
                    }

                    tr {
                        display: table-row;
                        vertical-align: inherit;
                    }

                    col {
                        display: table-column;
                    }

                    colgroup {
                        display: table-column-group;
                    }

                    tbody {
                        display: table-row-group;
                        vertical-align: middle;
                    }

                    thead {
                        display: table-header-group;
                        vertical-align: middle;
                    }

                    tfoot {
                        display: table-footer-group;
                        vertical-align: middle;
                    }

                    /* for XHTML tables without tbody */
                    table>tr {
                        vertical-align: middle;
                    }

                    td {
                        display: table-cell;
                        padding: 1px;
                    }

                    th {
                        display: table-cell;
                        vertical-align: inherit;
                        font-weight: bold;
                        padding: 1px;
                    }

                    /* Modified version of equivalent FF definitions */

                    sub {
                        vertical-align: sub;
                        font-size: 0.83em;
                        line-height: normal;
                    }

                    sup {
                        vertical-align: super;
                        font-size: 0.83em;
                        line-height: normal;
                    }

                    hr {
                        display: block;
                        border: 1px inset;
                        margin: 0.5em auto 0.5em auto;
                    }

                    hr[size="1"] {
                        border-width: 1px 0 0 0;
                        border-style: solid none none none;
                    }

                    /* Custom styles */
                    #annexurehtml::before {
                        border-top: 2px dashed #000;
                        position: relative;
                        margin: 0 -38px 10px -53px;
                        display: block;
                        content: "";
                    }

                    a {
                        color: #408dfb;
                        text-decoration: none;
                    }

                    th {
                        text-align: inherit;
                    }
                </style>
                <div id="shadow-host-container">
                    <style media="all" type="text/css">
                        @font-face {
                            font-family: "WebFont-Ubuntu";
                            src:
                                local(Ubuntu),
                                url(https://fonts.gstatic.com/s/ubuntu/v10/4iCs6KVjbNBYlgoKcg72nU6AF7xm.woff2);
                        }

                        .pcs-template {
                            font-family: Ubuntu, "WebFont-Ubuntu";
                            font-size: 8pt;
                            color: #000000;
                            background: #ffffff;
                        }

                        .pcs-header-content {
                            font-size: 8pt;
                            color: #000000;
                            background-color: #ffffff;
                        }

                        .pcs-template-body {
                            padding: 0 0.4in 0 0.55in;
                        }

                        .pcs-template-footer {
                            height: 0.7in;
                            font-size: 8pt;
                            color: #6c718a;
                            padding: 0 0.4in 0 0.55in;
                            background-color: #ffffff;
                        }

                        .pcs-footer-content {
                            word-wrap: break-word;
                            color: #6c718a;
                            border-top: 1px solid #9e9e9e;
                        }

                        .pcs-label {
                            color: #333333;
                        }

                        .pcs-entity-title {
                            font-size: 22pt;
                            color: #000000;
                        }

                        .pcs-orgname {
                            font-size: 12pt;
                            color: #000000;
                        }

                        .pcs-customer-name {
                            font-size: 9pt;
                            color: #000000;
                        }

                        .pcs-eori-number {
                            color: #333;
                            margin: 0;
                            padding-top: 10px;
                        }

                        .pcs-itemtable-header {
                            font-size: 8pt;
                            color: #000000;
                            background-color: #f2f3f4;
                        }

                        .pcs-itemtable-breakword {
                            word-wrap: break-word;
                        }

                        .pcs-taxtable-header {
                            font-size: 8pt;
                            color: #000000;
                            background-color: #f2f3f4;
                        }

                        .breakrow-inside {
                            page-break-inside: avoid;
                        }

                        .breakrow-after {
                            page-break-after: auto;
                        }

                        .pcs-item-row {
                            font-size: 8pt;
                            border-bottom: 1px solid #9e9e9e;
                            background-color: #ffffff;
                            color: #000000;
                        }

                        .pcs-img-fit-aspectratio {
                            object-fit: contain;
                            object-position: top;
                        }

                        .pcs-item-sku,
                        .pcs-item-hsn,
                        .pcs-item-coupon,
                        .pcs-item-serialnumber,
                        .pcs-item-unitcode {
                            margin-top: 2px;
                            font-size: 10px;
                            color: #444444;
                        }

                        .pcs-item-desc {
                            color: #333333;
                            font-size: 8pt;
                        }

                        .pcs-balance {
                            background-color: #ffffff;
                            font-size: 9pt;
                            color: #000000;
                        }

                        .pcs-savings {
                            font-size: 0pt;
                            color: #000000;
                            background-color: #ffffff;
                        }

                        .pcs-totals {
                            font-size: 8pt;
                            color: #000000;
                            background-color: #ffffff;
                        }

                        .pcs-notes {
                            font-size: 8pt;
                        }

                        .pcs-terms {
                            font-size: 8pt;
                        }

                        .pcs-header-first {
                            background-color: #ffffff;
                            font-size: 8pt;
                            color: #000000;
                            height: auto;
                        }

                        .pcs-status {
                            color: ;
                            font-size: 15pt;
                            border: 3px solid;
                            padding: 3px 8px;
                        }

                        .billto-section {
                            padding-top: 0mm;
                            padding-left: 0mm;
                        }

                        .shipto-section {
                            padding-top: 0mm;
                            padding-left: 0mm;
                        }

                        @page :first {
                            @top-center {
                                content: element(header);
                            }

                            margin-top: 0.7in;
                        }

                        .pcs-template-header {
                            padding: 0 0.4in 0 0.55in;
                            height: 0.7in;
                        }

                        .pcs-template-fill-emptydiv {
                            display: table-cell;
                            content: " ";
                            width: 100%;
                        }

                        /* Additional styles for RTL compat */

                        /* Helper Classes */

                        .inline {
                            display: inline-block;
                        }

                        .v-top {
                            vertical-align: top;
                        }

                        .text-align-right {
                            text-align: right;
                        }

                        .rtl .text-align-right {
                            text-align: left;
                        }

                        .text-align-left {
                            text-align: left;
                        }

                        .rtl .text-align-left {
                            text-align: right;
                        }

                        .float-section-right {
                            float: right;
                        }

                        .rtl .float-section-right {
                            float: left;
                        }

                        .float-section-left {
                            float: left;
                        }

                        .rtl .float-section-left {
                            float: right;
                        }

                        /* Helper Classes End */

                        .item-details-inline {
                            display: inline-block;
                            margin: 0 10px;
                            vertical-align: top;
                            max-width: 70%;
                        }

                        .total-in-words-container {
                            width: 100%;
                            margin-top: 10px;
                        }

                        .total-in-words-label {
                            vertical-align: top;
                            padding: 0 10px;
                        }

                        .total-in-words-value {
                            width: 170px;
                        }

                        .total-section-label {
                            padding: 5px 10px 5px 0;
                            vertical-align: middle;
                        }

                        .total-section-value {
                            width: 120px;
                            vertical-align: middle;
                            padding: 10px 10px 10px 5px;
                        }

                        .rtl .total-section-value {
                            padding: 10px 5px 10px 10px;
                        }

                        .tax-summary-description {
                            color: #727272;
                            font-size: 8pt;
                        }

                        .bharatqr-bg {
                            background-color: #f4f3f8;
                        }

                        /* Overrides/Patches for RTL compat */
                        .rtl th {
                            text-align: inherit;
                            /* Specifically setting th as inherit for supporting RTL */
                        }

                        /* Overrides/Patches End */

                        /* Signature styles */
                        .sign-border {
                            width: 200px;
                            border-bottom: 1px solid #000;
                        }

                        .sign-label {
                            display: table-cell;
                            font-size: 10pt;
                            padding-right: 5px;
                        }

                        /* Signature styles End */

                        /* Subject field styles */
                        .subject-block {
                            margin-top: 20px;
                        }

                        .subject-block-value {
                            word-wrap: break-word;
                            white-space: pre-wrap;
                            line-height: 14pt;
                            margin-top: 5px;
                        }

                        /* Subject field styles End*/

                        .pcs-sub-label {
                            color: #666;
                            font-size: 10px;
                        }

                        .pcs-hsnsummary-compact {
                            padding: 0;
                            margin-top: 3px;
                        }

                        .pcs-hsnsummary-label-compact {
                            margin-bottom: 3px;
                            font-weight: 600;
                            padding-left: 3px;
                            font-size: 9pt;
                        }

                        .pcs-hsnsummary-header-compact {
                            text-align: right;
                            padding: 5px 7px 2px 7px;
                            word-wrap: break-word;
                            width: 17%;
                            height: 32px;
                            border-right: 1px solid #9e9e9e;
                            font-size: 8pt;
                            font-weight: 600;
                        }

                        .pcs-hsnsummary-body-compact,
                        .pcs-hsnsummary-total-compact {
                            text-align: right;
                            word-wrap: break-word;
                            font-size: 7pt;
                            padding: 4px 10px;
                        }

                        .pcs-hsnsummary-total-compact {
                            border-top: 1px solid #9e9e9e;
                        }

                        .pcs-ukvat-summary {
                            margin-top: 50px;
                            clear: both;
                            width: 100%;
                        }

                        .pcs-ukvat-summary-header {
                            padding: 5px 10px 5px 5px;
                        }

                        .pcs-ukvat-summary-header:first-child {
                            padding-left: 10px;
                        }

                        .pcs-ukvat-summary-label {
                            font-size: 10pt;
                        }

                        .pcs-ukvat-summary-table {
                            margin-top: 10px;
                            width: 100%;
                            table-layout: fixed;
                        }

                        .pcs-ukvat-summary-body,
                        .pcs-ukvat-summary-total {
                            padding: 10px 10px 5px 10px;
                        }

                        .pcs-ukvat-summary-body:first-child {
                            padding-bottom: 10px;
                            padding-right: 0;
                        }

                        .pcs-payment-block {
                            margin-top: 20px;
                        }

                        .pcs-payment-block-inner {
                            margin-top: 10px;
                        }

                        .pcs-entity-label-section {
                            padding: 5px 10px 5px 0px;
                            font-size: 10pt;
                        }

                        .pcs-colon {
                            width: 3%;
                        }

                        .retention-block-label {
                            padding: 5px 10px 5px 0;
                        }

                        .retention-block-value {
                            padding: 10px 10px 10px 5px;
                        }

                        .pcs-d-inline {
                            display: inline;
                        }

                        .bank-details-section {
                            margin-top: 10px;
                            width: 100%;
                            word-wrap: break-word;
                        }

                        .pcs-w-100 {
                            width: 100%;
                        }

                        .pcs-h-10px {
                            height: 10px;
                        }

                        .pcs-w-120px {
                            width: 120px;
                        }

                        .pcs-w-110px {
                            width: 110px;
                        }

                        .pcs-w-50 {
                            width: 50%;
                        }

                        .pcs-d-table-cell {
                            display: table-cell;
                        }

                        .pcs-talign-center {
                            text-align: center;
                        }

                        .pcs-wordwrap-bw {
                            word-wrap: break-word;
                        }

                        .pcs-whitespace-pw {
                            white-space: pre-wrap;
                        }

                        .pcs-fw-600 {
                            font-weight: 600;
                        }

                        .pcs-text-uppercase {
                            text-transform: uppercase;
                        }

                        .pcs-text-underline {
                            text-decoration: underline;
                        }

                        .pcs-text-red {
                            color: red;
                        }

                        .pcs-dark-grey {
                            color: #666;
                        }

                        .pcs-fs-10 {
                            font-size: 10px;
                        }

                        .pcs-fs-12 {
                            font-size: 12px;
                        }

                        .pcs-table-fixed {
                            table-layout: fixed;
                        }

                        .pcs-valign-middle {
                            vertical-align: middle;
                        }

                        .pcs-clearfix {
                            clear: both;
                        }

                        .pcs-pb-0 {
                            padding-bottom: 0px;
                        }

                        .pcs-pb-5 {
                            padding-bottom: 5px;
                        }

                        .pcs-pb-2 {
                            padding-bottom: 2px;
                        }

                        .pcs-pt-20 {
                            padding-top: 20px;
                        }

                        .pcs-pt-5 {
                            padding-top: 5px;
                        }

                        .pcs-pt-10 {
                            padding-top: 10px;
                        }

                        .pcs-pt-3 {
                            padding-top: 3px;
                        }

                        .pcs-pt-0 {
                            padding-top: 0px;
                        }

                        .pcs-px-10 {
                            padding-right: 10px;
                            padding-left: 10px;
                        }

                        .pcs-py-0 {
                            padding-top: 0px;
                            padding-bottom: 0px;
                        }

                        .pcs-mt-5 {
                            margin-top: 5px;
                        }

                        .pcs-px-20 {
                            padding-right: 20px;
                            padding-left: 20px;
                        }

                        .pcs-py-10 {
                            padding-top: 10px;
                            padding-bottom: 10px;
                        }

                        .pcs-ps-5 {
                            padding-left: 5px;
                        }

                        .pcs-pe-10 {
                            padding-right: 10px;
                        }

                        .word-wrap-break-word {
                            word-wrap: break-word;
                        }

                        .pcs-border-color-ebeaf2 {
                            border-color: #ebeaf2 !important;
                        }

                        .page-break-inside-avoid {
                            -webkit-column-break-inside: avoid;
                            page-break-inside: avoid;
                            break-inside: avoid;
                        }

                        .pcs-template-bodysection {
                            border: 1px solid #9e9e9e;
                        }

                        .pcs-itemtable {
                            border-top: 1px solid #9e9e9e;
                        }

                        .pcs-addresstable {
                            width: 100%;
                            table-layout: fixed;
                        }

                        .pcs-addresstable>thead>tr>th {
                            padding: 1px 5px;
                            background-color: #f2f3f4;
                            font-weight: normal;
                            border-bottom: 1px solid #9e9e9e;
                        }

                        .pcs-addresstable>tbody>tr>td {
                            line-height: 15px;
                            padding: 5px 5px 0px 5px;
                            vertical-align: top;
                            word-wrap: break-word;
                        }

                        .invoice-detailstable>tbody>tr>td {
                            width: 50%;
                            vertical-align: top;
                            border-top: 1px solid #9e9e9e;
                        }

                        .invoice-detailstable>tbody>tr>td>span {
                            width: 45%;
                            padding: 1px 5px;
                            display: inline-block;
                            vertical-align: top;
                        }

                        .pcs-itemtable-header {
                            font-weight: normal;
                            border-right: 1px solid #9e9e9e;
                            border-bottom: 1px solid #9e9e9e;
                        }

                        .pcs-itemtable-subheader {
                            padding: 1px 5px;
                            text-align: right;
                        }

                        .pcs-item-row {
                            border-right: 1px solid #9e9e9e;
                            border-bottom: 1px solid #9e9e9e;
                        }

                        .pcs-itemtable tr td.pcs-itemtable-subheader:last-child {
                            border-right: 1px solid #9e9e9e;
                        }

                        .pcs-itemtable tr td.pcs-itemtable-subrow:last-child {
                            border-right: 1px solid #9e9e9e;
                        }

                        .pcs-itemtable tr td:last-child,
                        .pcs-itemtable tr th:last-child {
                            border-right: 0px;
                        }

                        .pcs-itemtable tr td:first-child,
                        .pcs-itemtable tr th:first-child {
                            border-left: 0px;
                        }

                        .pcs-itemtable tbody>tr>td {
                            padding: 1px 5px;
                            word-wrap: break-word;
                        }

                        .pcs-totaltable tbody>tr>td {
                            padding: 4px 7px 0px;
                            text-align: right;
                        }

                        .pcs-footer-content {
                            border-top: 0px;
                        }

                        #tmp_vat_summary_label,
                        .pcs-retainer-payment {
                            padding: 4px 4px 3px 7px;
                        }

                        .pcs-retainer-payment #tmp_vat_summary_label {
                            padding: 0;
                        }

                        .subject-block {
                            margin-top: 0px;
                            padding: 10px;
                            border-top: 1px solid #9e9e9e;
                        }

                        .pcs-taxtable-header {
                            border-bottom: 1px solid #9e9e9e;
                            border-right: 1px solid #9e9e9e;
                        }

                        .export-info-content {
                            text-align: center;
                            font-style: italic;
                            padding-top: 15px;
                            color: #848484;
                            font-size: 11px;
                            padding-bottom: 15px;
                        }
                    </style>

                    <div class="pcs-template">
                        <div class="pcs-template-header pcs-header-content" id="header">
                            <div class="pcs-template-fill-emptydiv"></div>
                        </div>

                        <div class="pcs-template-body">
                            <div class="pcs-template-bodysection">
                                <table style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td
                                                style="
                            width: 10%;
                            padding: 2px 10px;
                            vertical-align: middle;
                          ">
                                                <img src="https://invoice.zoho.in/ZFInvoiceLogo.zbfs?logo_id=e13683ab0b1b999a8c3f13588815067e"
                                                    style="width: 150px; height: 120px" id="logo_content"
                                                    loading="lazy" />
                                            </td>
                                            <td
                                                style="
                            width: 50%;
                            padding: 2px 10px;
                            vertical-align: middle;
                          ">
                                                <div>
                                                    <div style="
                                font-weight: bold;
                                line-height: 1;
                                margin-bottom: 7px;
                              "
                                                        class="pcs-orgname">
                                                        Digitechhealthcare
                                                    </div>
                                                    <span style="white-space: pre-wrap" id="tmp_org_address">The First
                                                        Business Brick B74 Sector 2 Noida Uttar
                                                        Pradesh 201301 India GSTIN 09TVNPS0530J1ZQ
                                                        9289738874 ritusinghhealthcare@gmail.com
                                                        https://digitechhealthcare.com/</span>
                                                </div>
                                            </td>
                                            <td style="
                            width: 40%;
                            padding: 5px;
                            vertical-align: bottom;
                          "
                                                align="right">
                                                <div class="pcs-entity-title">TAX INVOICE</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div style="width: 100%">
                                    <table cellspacing="0" cellpadding="0" border="0"
                                        style="
                        width: 100%;
                        table-layout: fixed;
                        word-wrap: break-word;
                      "
                                        class="invoice-detailstable">
                                        <thead>
                                            <tr>
                                                <th style="width: 50%"></th>
                                                <th style="width: 50%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="
                              border-right: 1px solid #9e9e9e;
                              padding-bottom: 10px;
                            ">
                                                    <span class="pcs-label">#</span>
                                                    <span style="font-weight: 600" id="tmp_entity_number">:
                                                        {{ $invoice->invoice_number }}</span>

                                                    <span class="pcs-label">Invoice Date</span>
                                                    <span style="font-weight: 600" id="tmp_entity_date">:
                                                        {{ $invoice->invoice_date->format('d/m/Y') }}</span>

                                                    <span class="pcs-label">Terms</span>
                                                    <span style="font-weight: 600" id="tmp_payment_terms">: Due on
                                                        Receipt</span>

                                                    <span class="pcs-label">Due Date</span>
                                                    <span style="font-weight: 600" id="tmp_due_date">:
                                                        {{ $invoice->due_date->format('d/m/Y') }}</span>
                                                </td>
                                                <td style="padding-bottom: 10px">
                                                    <span class="pcs-label">Place Of Supply</span>
                                                    <span style="font-weight: 600">
                                                        {{-- : Karnataka (29) --}}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div style="clear: both"></div>

                                <table style="" class="pcs-addresstable" border="0" cellspacing="0"
                                    cellpadding="0">
                                    <thead>
                                        <tr>
                                            <th style="border-top: 1px solid #9e9e9e">
                                                <label style="margin-bottom: 0px; display: block"
                                                    id="tmp_billing_address_label" class="pcs-label"><b>Bill
                                                        To</b></label>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding-bottom: 10px" valign="top">
                                                <span style="white-space: pre-wrap; line-height: 15px"
                                                    id="tmp_billing_address">
                                                    <strong>
                                                        <span class="pcs-customer-name"
                                                            id="zb-pdf-customer-detail">{{ $invoice->client->name }}</span>
                                                    </strong>
                                                    {{ $invoice->client->company_name }}<br>
                                                    {{ $invoice->client->email }}<br>
                                                    {{ $invoice->client->phone }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div style="clear: both"></div>

                                <table style="width: 100%; table-layout: fixed; clear: both" class="pcs-itemtable"
                                    id="itemTable" cellspacing="0" cellpadding="0" border="0">
                                    <thead>
                                        <tr style="height: 17px">
                                            <td style="
                            padding: 5px 5px 2px 5px;
                            width: 5%;
                            text-align: center;
                          "
                                                valign="bottom" rowspan="2" id=""
                                                class="pcs-itemtable-header pcs-itemtable-breakword">
                                                <b>#</b>
                                            </td>
                                            <td style="
                            padding: 5px 7px 2px 7px;
                            width:;
                            text-align: left;
                          "
                                                valign="bottom" rowspan="2" id=""
                                                class="pcs-itemtable-header pcs-itemtable-breakword">
                                                <b>Item &amp; Description</b>
                                            </td>
                                            <td style="
                            padding: 5px 7px 2px 7px;
                            width: 11%;
                            text-align: right;
                          "
                                                valign="bottom" rowspan="2" id=""
                                                class="pcs-itemtable-header pcs-itemtable-breakword">
                                                <b>Qty</b>
                                            </td>
                                            <td style="
                            padding: 5px 7px 2px 7px;
                            width: 11%;
                            text-align: right;
                          "
                                                valign="bottom" rowspan="2" id=""
                                                class="pcs-itemtable-header pcs-itemtable-breakword">
                                                <b>Rate</b>
                                            </td>
                                            <td style="
                            padding: 5px 7px 2px 7px;
                            width: 11%;
                            text-align: center;
                          "
                                                valign="bottom" colspan="2" id=""
                                                class="pcs-itemtable-header pcs-itemtable-breakword">
                                                <b>IGST</b>
                                            </td>
                                            <td style="
                            padding: 5px 7px 2px 7px;
                            width: 13%;
                            text-align: right;
                          "
                                                valign="bottom" rowspan="2" id=""
                                                class="pcs-itemtable-header pcs-itemtable-breakword">
                                                <b>Amount</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="pcs-itemtable-header pcs-itemtable-breakword pcs-itemtable-subheader">
                                                <b>%</b>
                                            </td>
                                            <td
                                                class="pcs-itemtable-header pcs-itemtable-breakword pcs-itemtable-subheader">
                                                <b>Amt</b>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody class="itemBody">
                                        @foreach ($invoice->items as $index => $item)
                                            <tr class="breakrow-inside breakrow-after" style="height: 20px">
                                                <td rowspan="1" valign="top" style="text-align: center"
                                                    class="pcs-item-row">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td rowspan="1" valign="top" class="pcs-item-row"
                                                    id="tmp_item_name">
                                                    <div style="">
                                                        <div>
                                                            <span style="word-wrap: break-word"
                                                                id="tmp_item_name">{{ $item->description }}</span><br />
                                                            {{-- <span
                                                            style="
                                  white-space: pre-wrap;
                                  word-wrap: break-word;
                                "
                                                            class="pcs-item-desc" id="tmp_item_description">With
                                                            GST</span><br /> --}}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td rowspan="1" valign="top" style="text-align: right"
                                                    class="pcs-item-row" id="tmp_item_qty">
                                                    {{ number_format($item->qty, 2) }}
                                                </td>

                                                <td rowspan="1" valign="top" style="text-align: right"
                                                    class="pcs-item-row" id="tmp_item_rate">
                                                    {{ number_format($item->price, 2) }}
                                                </td>

                                                <td rowspan="1" valign="top" style="text-align: right"
                                                    class="pcs-item-row">
                                                    <div>0%</div>
                                                </td>
                                                <td rowspan="1" valign="top" style="text-align: right"
                                                    class="pcs-item-row">
                                                    <div id="tmp_item_tax_amount">0.00</div>
                                                </td>
                                                <td rowspan="1" valign="top" style="text-align: right"
                                                    class="pcs-item-row" id="tmp_item_amount">
                                                    {{ number_format($item->total, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div style="width: 100%; margin-top: 1px">
                                    <div style="width: 50%; padding: 4px 4px 3px 7px; float: left">
                                        <div style="margin: 10px 0 5px">
                                            <div style="padding-right: 10px">Total In Words</div>
                                            <span><b><i>{{ $amountInWords }}</i></b></span>
                                        </div>
                                        <div style="padding-top: 10px">
                                            <span id="tmp_notes_label" class="pcs-label">Notes</span>
                                            <p style="
                            white-space: pre-wrap;
                            word-wrap: break-word;
                            margin-top: 0;
                          "
                                                class="pcs-notes">
                                                Thanks for your business.
                                                {{-- This is an quarterly
                                                invoice. Dec-Feb 2026  --}}
                                                Name : DIGITECH HEALTHCARE Bank
                                                : STATE BANK OF INDIA Account No. : 44269799065 IFSC
                                                Code : SBIN0062292 Branch : OMICRON 3
                                            </p>
                                        </div>

                                        <div style="clear: both; margin-top: 20px; width: 100%">
                                            <div id="tmp_terms_label" class="pcs-label">
                                                Terms &amp; Conditions
                                            </div>
                                            <div style="white-space: pre-wrap; word-wrap: break-word"
                                                class="pcs-terms">
                                                • If clients choose any monthly service package from
                                                Digitech Healthcare, they are required to pay the full
                                                amount in advance before the commencement of the work
                                                • If Digitech Healthcare and the client agree on a
                                                fixed quote regarding any services then they are
                                                liable to pay 50% of the billable amount in advance,
                                                prior to the commencement of the work. The remaining
                                                50% of the payment will have to be made within 7 days
                                                of the start date of the services. • Digitech
                                                Healthcare shall invoice the clients monthly, in
                                                advance. • We will use your logo for the Branding
                                                purpose for Digidotes. • If you have any queries or
                                                doubts, please let us know. Thanks and Regards
                                                Digitech Healthcare
                                            </div>
                                        </div>
                                    </div>
                                    <div style="width: 43.6%; float: right" class="pcs-totals">
                                        <table style="border-left: 1px solid #9e9e9e" class="pcs-totaltable"
                                            id="itemTable" cellspacing="0" border="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td valign="middle">Sub Total</td>
                                                    <td id="tmp_subtotal" valign="middle" style="width: 110px">
                                                        ₹{{ number_format($invoice->subtotal, 2) }}
                                                    </td>
                                                </tr>
                                                @if ($invoice->discount > 0)
                                                    <tr>
                                                        <td valign="middle">Discount</td>
                                                        <td id="tmp_subtotal" valign="middle" style="width: 110px">
                                                            ₹{{ number_format($invoice->subtotal, 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($invoice->tax > 0)
                                                    <tr style="height: 10px">
                                                        <td valign="middle" align="right">IGST0 (0%)</td>
                                                        <td valign="middle" style="width: 110px">₹{{ number_format($invoice->tax, 2) }}</td>
                                                    </tr>
                                                @else
                                                    <tr style="height: 10px">
                                                        <td valign="middle" align="right">IGST0 (0%)</td>
                                                        <td valign="middle" style="width: 110px">₹0.00</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td valign="middle"><b>Total</b></td>
                                                    <td id="tmp_total" valign="middle" style="width: 110px">
                                                        <b>₹{{ number_format($invoice->total_amount, 2) }}</b>
                                                    </td>
                                                </tr>

                                                <tr style="height: 10px" class="pcs-balance">
                                                    <td valign="middle"><b>Balance Due</b></td>
                                                    <td id="tmp_balance_due" valign="middle" style="width: 110px">
                                                        <strong>₹{{ number_format($invoice->total_amount, 2) }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border-bottom: 1px solid #9e9e9e" colspan="2"></td>
                                                </tr>
                                            </tbody>

                                            <tbody class="page-break-inside-avoid">
                                                <tr>
                                                    <td style="text-align: center; padding-top: 5px" colspan="2">
                                                        <div style="min-height: 75px"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="
                                text-align: center;
                                border-bottom: 1px solid #9e9e9e;
                              "
                                                        colspan="2">
                                                        <label style="margin-bottom: 0px"
                                                            class="pcs-totals">Authorized Signature</label>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="clear: both"></div>

                                    <div style="clear: both"></div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 15px" class="pcs-template-footer">
                            <div></div>
                            <div style="text-align: center; direction: ltr"></div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <!---->
    </div>
</body>

</html>
