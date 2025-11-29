<link rel="stylesheet" href="<?= base_url("assets/") ?>css/jquery.steps.css">
<style>
    .error{
        margin-top: 5px !important;
        color:indianred;
    }
    body.dark input.error {
        border: 1px solid #f96262 !important;
        background-color: rgba(200,27,27,0.1);
    }
    body.dark textarea.error {
        border: 1px solid #f96262 !important;
    }

    body.dark select.error {
        border: 1px solid #f96262 !important;
    }
    .verification-email-popup2 {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100vh;
        background: #000000c9;
        z-index: 50;
        display: none;
    }
    .message-popup2 .box .cls {
        position: absolute;
        right: -60px;
        top: 0px;
        border: 1px solid #fff;
        border-radius: 50%;
        cursor: pointer;
        color: #fff;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
    }
    .verification-email-popup2 .box .cls {
        position: absolute;
        right: -60px;
        top: 0px;
        border: 1px solid #fff;
        border-radius: 50%;
        cursor: pointer;
        color: #fff;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
    }
    .message-popup2 .box {
        position: absolute;
        left: 50%;
        top: 10%;
        width: 500px;
        height: 450px;
        background: #fff;
        transform: translate(-50%,0);
        padding: 30px 30px 60px 30px;
        border-radius: 10px;
    }
    .verification-email-popup2 .box {
        position: absolute;
        left: 50%;
        top: 50%;
        width: 400px;
        height: auto;
        padding-bottom: 15px;
        background: #fff;
        transform: translate(-50%,-50%);
        border-radius: 10px;
    }
    .message-popup2 {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100vh;
        background: #000000c9;
        z-index: 50;
        display: none;
    }
    #ilanBasarili .box span {
        color: #393939 !important;
    }
    body.dark #ilanBasarili .box span {
        color: white !important;
    }

    .ilanDetayBtn{
        background-color:#329a86;
        margin-right: 15px;
        padding: 10px;
        display: inline-block;
        color: #fff;
        margin-top: 20px !important;
        border-radius: 4px;
    }
    body.dark .textTitleCustom{
        color:white;
    }
    .cls2{
         margin-right: 85px !important;
     }

    #sif tbody tr td{
        border-bottom : none !important;
    }
    .verification-email-popup .box{
        padding-bottom: 55px !important;
    }

    @media only screen and (max-width: 500px){

        .section-title span {
            font-size: 15px !important;
        }
        .cls2{
            margin-right: 60px !important;
        }
        .verification-email-popup .box form{
            padding:6px !important;
        }
        .verification-email-popup .box{
            padding-bottom: 55px !important;
        }
    }
    .table-orders{
        background-color: #eeeff5 !important;
    }
    body.dark .table-orders {
        background-color: #0d1826 !important;
    }
</style>