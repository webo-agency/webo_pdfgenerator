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
        <div id="image" class="absolute" style="top: 115px;left:38px;background-color:#f8f8f8;height:451px;width:754px;overflow:hidden;">
            <img src="{$action.picture}" height="451px" width="auto" style="display:inline-block;"/>
        </div>
    </body>
</html>