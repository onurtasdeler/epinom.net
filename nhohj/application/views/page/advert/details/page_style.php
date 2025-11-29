

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>


    .oneLi {
        position: relative;
    }

    .oneLi i {
        font-size: 20pt;
    }
    .name a{
        color:#393939 !important;
    }
    .clink{
        color:#393939;
    }
    body.dark .text-white{
        color:white !important;
    }
    body.dark .clink{
        color:white;
    }

    .oneLi .after {
        opacity: 0;
        position: absolute;
        background-color: #66d980;
        width: 290px;
        left: -53px;
        color: #FFFFFF;
        z-index: 9999;
        top: -28px;
        line-height: 22px;
        height: 22px;
        border-radius: 5px;
        transition: 500ms all ease-in-out;
    }

    .ilanAciklama {
        color: #2e383c;
    }

    .ilanAciklama .section-title {
        margin-top: 5px !important;
        margin-bottom: 10px !important;
    }

    .verification-email-popup .box {
        width: 650px !important;
    }




    .ilanAciklama .detayAciklama {
        margin-top: 5px !important;
        overflow-y: scroll;
        min-height: 150px;
        float: left;
    }
    #satildiCont{
        background-color: #ff0000;
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 999999 !important;
        top: 0px;
        opacity: 0.6;
        display: flex;
        margin: 0 auto;
        justify-content: center;
        align-items: center;
    }
    #satildiCont h5{
        text-align: center;
        color: white;
        font-size: 25pt;
    }

    #ilanBasarisiz .box span{
        text-align: center !important;
    }
    .message-popup .box #emailBilgi   {
        font-size: 14pt !important;
    }

    .list-unstyled {
        height: 100px;
        float: left;
        width: 100%;
        overflow-x: hidden;
        overflow-y: scroll;
    }

    .list-unstyled::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    .list-unstyled::-webkit-scrollbar-track {
        background: #F4F7FC;
    }

    body.dark .list-unstyled::-webkit-scrollbar-track {
        background: #2d2e3c;
    }

    /* Handle */
    body.dark .list-unstyled::-webkit-scrollbar-thumb {
        background: #4c4c52;
        border-radius: 10px;
    }

    .ilan-icerik-page .ilan-main .ilan-details .seller-info {
        padding: 22px 0px 10px 20px !important;
    }

    .oneLi .after2 {
        opacity: 0;
        position: absolute;
        background-color: rgba(229, 42, 42, 0.84);
        width: 290px;
        color: #fff;
        z-index: 9999;
        top: -28px;
        line-height: 22px;
        height: 22px;
        border-radius: 5px;
        transition: 500ms all ease-in-out;
    }

    .oneLi .after:after {
        bottom: -14px;
        left: 72px;
        border: solid transparent;
        rotate: 180deg;
        content: " ";
        height: 0;
        top: 22px;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #66d980;
        border-width: 10px;
        margin-left: -10px;
    }

    .oneLi .after2:after {
        bottom: -14px;
        left: 72px;
        border: solid transparent;
        rotate: 180deg;
        content: " ";
        height: 0;
        top: 22px;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: rgba(229, 42, 42, 0.84);;
        border-width: 10px;
        margin-left: -10px;
    }

    .oneLi:hover .after {
        opacity: 1;
    }

    .oneLi:hover .after2 {
        opacity: 1;
    }

    @media only screen and (min-width: 300px) and (max-width: 600px) {
        .ilan-slider img {
            width: 100% !important;
            height: 100% !important;
        }

        .message-popup .box    {
            width: 350px !important;
        }
        .ilan-icerik-page .ilan-main .ilan-details .seller-info .detail {
            margin-left: 7px !important;
        }

        .ilan-icerik-page .ilan-main .ilan-details .seller-info .detail .badge {
            margin-left: 2px !important;
        }

        .ilan-main .ilan-details .seller-info .seller-contacts {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: horizontal !important;
            -webkit-box-direction: normal !important;
            -ms-flex-direction: column !important;
            flex-direction: column !important;
            margin-right: auto;
            margin-left: 0 !important;
            margin-top: 10px;
            width: 100%;
        }

        .ilan-main .ilan-details .seller-info .seller-contacts a {
            width: 180px;
            border-radius: 38px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            background-color: #FF5471;
            color: #fff;
            margin-bottom: 8px;
            transition: .5s;
            -webkit-transition: .5s;
            text-align: center;
            -moz-transition: .5s;
            -o-transition: .5s;
            -ms-transition: .5s;
        }

        .ilan-icerik-page .ilan-main .ilan-details .ilan-pricing .price b {
            font-size: 23px !important;
        }

        .ilan-icerik-page .ilan-main .ilan-details .seller-info .seller-contacts a img {
            margin-right: 6px;
        }

        .ilan-icerik-page .ilan-main .ilan-details .seller-info .seller-contacts a:last-child {
            background-color: #54A4FF;
        }

        .seller-contacts a {
            height: 24px !important;
            width: 100% !important;
            padding: 2px;
        }

        .oneliright .after {
            right: -3px !important;
        }

        .oneliright .after:after {
            left: 213px;
        }

        .oneliright .after2 {
            right: -3px !important;
        }

        .oneliright .after2:after {
            left: 213px;
        }

        .onelileft .after {

        }

        .onelileft .after:after {
            left: 74px;
        }

        .onelileft .after2 {

        }

        .onelileft .after2:after {
            left: 74px;
        }
    }


</style>