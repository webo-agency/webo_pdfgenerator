<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
       <style type="text/css">
            body * {
                font-family: "Nomada Didone"!important;
            }
            @page {
                margin: 0;
            }
            body {
                background-size: 100%;
                background-repeat: no-repeat;
               
                width: 100%;
            }
            .absolute{
                position: absolute;
            }

            .param-text{
                font-family:'Roboto-Light', 'Roboto';
                font-weight:300;
                font-size:12px;
                color:rgb(35,35,34);
            }

            .size{
    			font-family: 'Roboto-Medium', 'Roboto';
    			font-weight: 500;
    			font-size: 10px;
   			color: rgb(173,175,186);
    		   }
        </style>
    </head>
    <body>
  <img src="{$background}" width="100%" height="100%"/>
        <div id="image" class="absolute" style="top: 105px;left:45px">
            <img src="{$action.picture}" height="460px" width="460px" style="max-width: none;min-height: auto;min-width: auto;"/>
        </div>
    </body>
</html>