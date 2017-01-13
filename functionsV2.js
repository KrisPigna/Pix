var upload = document.getElementById('upload');
var placeholder = document.getElementById("placeholder");
var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");
var orgImg = document.createElement('canvas');
var orgCtx = orgImg.getContext("2d");
var filterImg = document.createElement('canvas');
var filterCtx = filterImg.getContext("2d");

window.onload = function() {
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    ctx.drawImage(placeholder, 0, 0, c.width, c.height);
}

function uploadImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(event){
        var img = new Image();
        img.onload = function(){ 
            c.height = img.height;
            c.width = img.width;
            ctx.drawImage(img, 0, 0, img.width, img.height);
            orgImg.height = img.height;
            orgImg.width = img.width;
            orgCtx.drawImage(img, 0, 0, img.width, img.height);
            filterImg.height = img.height;
            filterImg.width = img.width;
            filterCtx.drawImage(img, 0, 0, img.width, img.height);
        }
        img.src = event.target.result;
    }
    reader.readAsDataURL(input.files[0]); 
        
        
       /* var reader = new FileReader();
        
        reader.onload = function (e) {
            img.setAttribute('src', e.target.result);
            var c = document.getElementById("myCanvas");
            var ctx = c.getContext("2d");
            c.height = img.height;
            c.width = img.width;
            ctx.drawImage(img, 0, 0, img.width, img.height);
            orgImg.height = img.height;
            orgImg.width = img.width;
            orgCtx.drawImage(img, 0, 0, img.width, img.height);
            filterImg.height = img.height;
            filterImg.width = img.width;
            filterCtx.drawImage(img, 0, 0, img.width, img.height);
        }
        reader.readAsDataURL(input.files[0]);*/
    }
};

$("#upload").change(function(){
        uploadImage(this);
});

function saveImage(){
    var c = document.getElementById("myCanvas");
    var data = c.toDataURL('image/jpeg');
    $("#imgData").val(data);
};

function RotateLeft(){
   var c=document.getElementById("myCanvas");
    var ctx=c.getContext("2d");
    var backCanvas = document.createElement('canvas');
    backCanvas.width = c.width;
    backCanvas.height = c.height;
    var backCtx = backCanvas.getContext('2d');
    var w = c.width;
    var h = c.height;
    var angle = Math.PI / 2;
    // save main canvas contents
    backCtx.drawImage(c, 0,0,w,h);
    ctx.clearRect(0, 0, c.width, c.height);
    c.width = h;
    c.height = w;
    ctx.translate(Math.abs(w/2 * Math.cos(angle) + h/2 * Math.sin(angle)), Math.abs(h/2 * Math.cos(angle) + w/2 * Math.sin(angle)));
    ctx.rotate(-angle);
    ctx.translate(-w/2, -h/2);
    ctx.drawImage(backCanvas,0,0);
};

function RotateRight(){
    var c=document.getElementById("myCanvas");
    var ctx=c.getContext("2d");
    var backCanvas = document.createElement('canvas');
    backCanvas.width = c.width;
    backCanvas.height = c.height;
    var backCtx = backCanvas.getContext('2d');
    var w = c.width;
    var h = c.height;
    var angle = Math.PI / 2;
    // save main canvas contents
    backCtx.drawImage(c, 0,0,w,h);
    ctx.clearRect(0, 0, c.width, c.height);
    c.width = h;
    c.height = w;
    ctx.translate(Math.abs(w/2 * Math.cos(angle) + h/2 * Math.sin(angle)), Math.abs(h/2 * Math.cos(angle) + w/2 * Math.sin(angle)));
    ctx.rotate(angle);
    ctx.translate(-w/2, -h/2);
    ctx.drawImage(backCanvas,0,0);
};

function applyGrayscale()
{   
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    var imageData = orgCtx.getImageData(0, 0, orgImg.width, orgImg.height);
    var dataArray = imageData.data;

    for(var i = 0; i < dataArray.length; i += 4){
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        var alpha = dataArray[i + 3];
            
        var gray = (red + green + blue) / 3;
            
        dataArray[i] = gray;
        dataArray[i + 1] = gray;
        dataArray[i + 2] = gray;
        dataArray[i + 3] = alpha; // not changing the transparency
    }
    imageData.data = dataArray;
    ctx.putImageData(imageData, 0, 0);
    filterCtx.putImageData(imageData, 0, 0);
};

function applySepia() 
{   
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    var imageData = orgCtx.getImageData(0, 0, orgImg.width, orgImg.height);
    var dataArray = imageData.data;

    for(var i = 0; i < dataArray.length; i += 4){
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        
        dataArray[i]     = (red * 0.393)+(green * 0.769)+(blue * 0.189); // red
        dataArray[i + 1] = (red * 0.349)+(green * 0.686)+(blue * 0.168); // green
        dataArray[i + 2] = (red * 0.272)+(green * 0.534)+(blue * 0.131); // blue
    }
    imageData.data = dataArray;
    ctx.putImageData(imageData, 0, 0);
    filterCtx.putImageData(imageData, 0, 0);
};

function applyRed() 
{   
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    var imageData = orgCtx.getImageData(0, 0, orgImg.width, orgImg.height);
    var dataArray = imageData.data;

    for(var i = 0; i < dataArray.length; i += 4){
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        
        dataArray[i] = (red+green+blue)/3;        // apply average to red channel
        dataArray[i + 1] = dataArray[i + 2] = 0; // zero out green and blue channel
    }
    imageData.data = dataArray;
    ctx.putImageData(imageData, 0, 0);
    filterCtx.putImageData(imageData, 0, 0);
};

function applyGreen() 
{   
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    var imageData = orgCtx.getImageData(0, 0, orgImg.width, orgImg.height);
    var dataArray = imageData.data;

    for(var i = 0; i < dataArray.length; i += 4){
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        
        dataArray[i + 1] = (red+green+blue)/3;        // apply average to red channel
        dataArray[i] = dataArray[i + 2] = 0; // zero out green and blue channel
    }
    imageData.data = dataArray;
    ctx.putImageData(imageData, 0, 0);
    filterCtx.putImageData(imageData, 0, 0);
};

function applyBlue() 
{   
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext("2d");
    var imageData = orgCtx.getImageData(0, 0, orgImg.width, orgImg.height);
    var dataArray = imageData.data;

    for(var i = 0; i < dataArray.length; i += 4){
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        
        dataArray[i + 2] = (red+green+blue)/3;        // apply average to red channel
        dataArray[i] = dataArray[i + 1] = 0; // zero out green and blue channel
    }
    imageData.data = dataArray;
    ctx.putImageData(imageData, 0, 0);
    filterCtx.putImageData(imageData, 0, 0);
};

function applyBrightenFilter(value) 
{   
    var imageData = filterCtx.getImageData(0, 0, filterImg.width, orgImg.height);
    var dataArray = imageData.data;
    var amount = value - 100;
     for(var i = 0; i < dataArray.length; i += 4){
        dataArray[i] +=amount;
        dataArray[i+1] +=amount;
        dataArray[i+2] +=amount;
    }
    imageData.data = dataArray;
    var canvas = document.getElementById("myCanvas");
    var context = canvas.getContext('2d');
    context.putImageData(imageData, 0, 0);
};

function Original() 
{   
    var canvas = document.getElementById("myCanvas");
    var context = canvas.getContext('2d');
    context.drawImage(orgImg, 0, 0, orgImg.width, orgImg.height);
    filterCtx.drawImage(orgImg, 0, 0, orgImg.width, orgImg.height);
};

function checkAvailability(){
    jQuery.ajax({
        url: "php/functions.php",
        data:'userid='+$("#userid").val(),
        type: "POST",
        success:function(data){
            $("#available").html(data);
        },
        error:function (){}
    });
};