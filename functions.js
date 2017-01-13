var upload = document.getElementById('upload');
var image = new Image();
var orgImg = document.createElement('canvas');
var orgCtx = orgImg.getContext("2d");

function uploadImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            var width, height;
            var c = document.getElementById("myCanvas");
            var ctx = c.getContext("2d");
            image.setAttribute('src', e.target.result);
            if (image.width > 660) {
                height = image.height/image.width * 660;
                width = 660;
            }
            else{
                height = image.height;
                width = image.width;
            }
            c.height = height;
            c.width = width;
            ctx.drawImage(image, 0, 0, width, height);
            orgImg.height = height;
            orgImg.width = width;
            orgCtx.drawImage(image, 0, 0, width, height);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function BrightenFilter(input, value) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            var width, height;
            var c=document.createElement("CANVAS");
            var ctx=c.getContext("2d");
            image.setAttribute('src', e.target.result);
            if (image.width > 660){
                height = image.height/image.width * 660;
                width = 660;
            }
            else{
                height = image.height;
                width = image.width;
            }
            c.height = height;
            c.width = width;
            ctx.drawImage(image, 0, 0, width, height);
    var imageData = ctx.getImageData(0, 0, c.width, c.height);
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
    document.getElementById("brightval").setAttribute("value", amount);
        }
        reader.readAsDataURL(input.files[0]);
    }
};

$("#upload").change(function(){
    uploadImage(this);
});

function saveImage(){
    var c = document.getElementById("myCanvas");
    var data = c.toDataURL('image/jpg');
    $("#imgData").val(data);
};

/*function RotateLeft(){
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
};*/

function applyGrayscaleFilter() 
{   
    var c = document.getElementById("myCanvas");
    var ctx = c.getContext('2d');
    var imageData = ctx.getImageData(0, 0, c.width, c.height);
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
};

function applyBrightenFilter(value) 
{   
    var input = document.getElementById("upload");
    BrightenFilter(input, value);
};

function Original() 
{   
    var input = document.getElementById("upload");
    uploadImage(input);
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