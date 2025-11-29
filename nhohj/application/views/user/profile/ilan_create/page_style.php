<style>
    .form-group label {
        position: relative;
        cursor: pointer;
        position: relative;
        font-size: 14px;
        line-height: 24px !important;
        color: var(--color-body);
        font-weight: 400;
        padding-left: 33px !important;
        cursor: pointer;

    }
    #mainCategory-error,#topCategory,#subCategory{
        position: absolute;
        z-index: 98 !important;
        bottom: -55px;
        right: 8px;
    }
    #topCategory-error{
        position: absolute;
        z-index: 98 !important;
        bottom: -55px;
        right: 8px;
    }   #subCategory-error{
        position: absolute;
        z-index: 98 !important;
        bottom: -55px;
        right: 8px;
    }
    #times-error{
        position: absolute;
        z-index: 98 !important;
        bottom: -39px;
        right: 8px;
    }
    .select2-dropdown{
        z-index: 99 !important;
        width: 100%;
    }

    body.active-light-mode #option-1:checked:checked ~ .option-1, #option-2:checked:checked ~ .option-2 {
        border-color: #d2d5d7;
        background: #28c225;
    }
    body.active-light-mode #option-1:checked:checked ~ .option-1 span, #option-2:checked:checked ~ .option-2 span {
        color: #242435;
    }
    body.active-light-mode .option-2 a {
        color: #242435 !important;
    }

    body.active-light-mode .wrappers .option .dot {
        height: 20px;
        width: 20px;
        background: #212e48;
        border-radius: 50%;
        position: relative;
    }
    body.active-light-mode .select2-container .select2-selection--single .select2-selection__rendered {
        background: #f5f8fa;
        height: 50px;
        border-radius: 5px;
        color: #303131 !important;
        font-size: 14px;
        padding: 10px 20px;
        border: 2px solid #d2d5d7;
        transition: 0.3s;
    }

    body.active-light-mode .wrappers .option {
        background: #f5f8fa !important;
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: start;
        margin-left: 0px;
        color: #393939 !important;
        margin-right: 10px;
        border-radius: 5px;
        cursor: pointer;
        padding: 0 10px;
        border: 2px solid #80808014 !important;
        transition: all 0.3s ease;
    }
    #price-error,#nametr-error{
        color: #ff4267 !important;
        padding: 3px !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        position: absolute !important;
        display: block !important;
        z-index: 98;
        bottom: -13px;
    }
    label.error{
        color: #ff4267 !important;
        padding: 3px !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        position: absolute !important;
        display: block !important;
        z-index: 98;
        bottom: -37px;
    }
    .form-group label:before {
        content:'';
        -webkit-appearance: none;
        background-color: transparent;
        border: 2px solid #0079bf;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
        padding: 10px;
        display: inline-block;
        position: relative;
        vertical-align: middle;
        cursor: pointer;
        margin-right: 5px;
    }

    .form-group input:checked + label:after {
        content: '';
        display: block;
        position: absolute;
        top: 2px;
        left: 9px;
        width: 6px;
        height: 14px;
        border: solid var(--color-body);
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .tox .tox-toolbar, .tox .tox-toolbar__overflow, .tox .tox-toolbar__primary {
        background: url(data:image/svg+xml;charset=utf8,%3Csvg height='39px' viewBox='0 0 40 39px' width='40' xmlns='http://www.w3.org/2000/svg'%3E%3Crect x='0' y='38px' width='100' height='1' fill='%23000000'/%3E%3C/svg%3E) left 0 top 0 #222f3e;
        background-color: #242435;
        display: flex;
        flex: 0 0 auto;
        flex-shrink: 0;
        flex-wrap: wrap;
        padding: 0 0;
    }
    .select2-results__options::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    .select2-results__options::-webkit-scrollbar-track {
        background: #F4F7FC;
    }
    @media screen and (max-width: 700px) {
        .marginCustom{
            margin-top:40px;
        }
        .wrappers {
            display: inline-flex;
            height: 66%;
            width: 100%;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }
    }
    /* Handle */
    .select2-results__options::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.42);
        border-radius: 10px;
    }
</style>

<style>
    .default_images{
        object-fit: fill!important;
        cursor: pointer;
    }
    .default-opacity-55{
        opacity: 20%;
    }
    .default-opacity-100{
        opacity: 100%;
    }
    .default-hover-opacity-85{
        transition: .2s ease-in-out all;
    }
    .default-hover-opacity-85:hover{
        opacity:85%;
        transform: scale(1.2);
    }
</style>