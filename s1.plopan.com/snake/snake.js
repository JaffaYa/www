 

function highscoreTable(score){
	
	if(score<0){
		highscore.style.visibility='hidden';
		return;
	}
	
	var Result=highscore.getElementsByTagName('td');
	var lowestResult=Infinity;
	for(var i=0;i<Result.length;i++)
	{
		if(lowestResult>(+Result[i].innerHTML)&&!isNaN(+Result[i].innerHTML)){
			lowestResult=Result[i].innerHTML;	
		}
	}
	if (Result.length==0) lowestResult=0;
	
	if(lowestResult<score){
		 highscore.style.visibility='visible';
		 document.getElementsByTagName('input')[1].style.visibility='hidden';
		 document.getElementsByTagName('input')[1].value=score;
	}else{
		highscore.style.visibility='visible';
		document.getElementsByTagName('input')[2].value='ok';
		document.getElementsByTagName('input')[1].style.visibility='hidden';
		document.getElementsByTagName('input')[0].style.visibility='hidden';
		}	
		
}

function snakeGame(){
map.innerHTML = "";
var speedCounter=0;
var snakeSpeed=300;
var speed=0;
var score=0;
snakeDirection='right';
var snakeX=0;
var snakeY=0;
var navigation=new Array();
var snakeLength=3;
var snake=["0,0"];
var snakeTail=[];
var snakeClean=[];
var keyPress=true;
var cherry=false;
var cherryTimer=0;
var apple=false;
var pause=false;
//---------
function createMap(id){
//створення таблиці
var table= document.createElement("table");
var wrapper= document.createElement("div");
wrapper.id = "wrapper";

var tr=[]; 
var td=[];
map.appendChild(table);
map.appendChild(wrapper);



//Будування чисел сітки
	
for(var i=0;i<15;i++){
	 navigation[i] = new Array();
  tr[i]=document.createElement("tr");
  map.childNodes[0].appendChild(tr[i]);
    for(var j=0;j<15;j++){
      td[j]= document.createElement("td");
	  navigation[i][j]=map.childNodes[0].childNodes[i].appendChild(td[j]);
	  navigation[i][j].innerHTML = "";
      }
}

text=document.createElement("text");
map.insertBefore(text,table);
map.childNodes[0].innerHTML="Score:"+score+" Speed:"+speed;
navigation[0][0].style.background="red";
//----------------------------------------------------------

//-----------------------------------------------
}




function collision(){
	
	if (snakeX>14 || snakeY>14 || snakeX<0 || snakeY<0 || navigation[snakeX][snakeY].value=='snake')
	{
		 clearInterval(timerId);
		 
		document.getElementById('highscore');
		highscoreTable(score);
		 return true;
	}
	if (navigation[snakeX][snakeY].value=='apple'){
		snakeLength++;
		score++;
		apple=false;
	}
	if (navigation[snakeX][snakeY].value=='cherry'){
		snakeLength++;
		score+=5;
		speedCounter=0;
		cherry=false;
	}
}



function createCherry()
{
	
	function deleteCherry(){
		if (cherryTimer<0){
		if (navigation[randX][randY].value=='cherry')
		{
		cherry=false;
		navigation[randX][randY].value='';
		navigation[randX][randY].style.background="0";
		}
		clearInterval(cherryTimer);
		}
		return;
	}
	if(cherry)return; //не создавать если есть
	  var randX = 0 + Math.random() * (14 - 0)
	  randX = Math.round(randX);
		var randY = 0 + Math.random() * (14 - 0)
	  randY = Math.round(randY);
	if(navigation[randX][randY].value=='snake'|| navigation[randX][randY].value=='apple'){
		console.log("danger!!!"); 
		createCherry();
	}else{
		cherry=true;
		cherryTimer=25;
		var delCherryTimer=setInterval(deleteCherry, 1000);
	  navigation[randX][randY].value='cherry';
	navigation[randX][randY].style.background="url(cherry.svg)";
	}
}

function createApple()
{
  var randX = 0 + Math.random() * (14 - 0)
  randX = Math.round(randX);
	var randY = 0 + Math.random() * (14 - 0)
  randY = Math.round(randY);
if(navigation[randX][randY].value=='snake'){
	console.log("cherry!!!");
	createApple();  //danger!!!!
	createCherry();
}else{
	apple=true;
  navigation[randX][randY].value='apple';
navigation[randX][randY].style.background="url(apple.svg)";
}
  //console.log(randX,randY);
  
}

function game()
{
if (pause){ }else
{
keyPress=true;

//-------------------------
	left=function(){
		if(snakeDirection!="right") snakeDirection="left";
	keyPress=false;
	}
	right=function (){
		if(snakeDirection!="left")	 snakeDirection="right";
  keyPress=false;
	}
	down=function (){
		if(snakeDirection!="up") snakeDirection="down";
	keyPress=false;
	}
	up=function (){
		if(snakeDirection!="down")snakeDirection="up";
  keyPress=false;
	}

  addEventListener("keydown", function(event) {
    if (event.keyCode == 38 && keyPress==true){
		 up();
  }
  });
  
  addEventListener("keydown", function(event) {
    if (event.keyCode == 40 && keyPress==true){
		down();
	}
  });
  
  addEventListener("keydown", function(event) {
    if (event.keyCode == 37 && keyPress==true){
		left();
	}
  });
  
  addEventListener("keydown", function(event) {
    if (event.keyCode == 39 && keyPress==true){
		right();
	}
		//map.table.style.backgroundColor=("#0f0");
  });
  

 //-------------------------




switch (snakeDirection){
	case 'left': snakeY--; break;
	case 'right': snakeY++; break;
	case 'up': snakeX--;break;
	case 'down': snakeX++; break;
	default: break;
}

if(collision()){return};
snake.push(""+snakeX+","+snakeY);
if (snakeLength>0){
	 snakeLength--;
}else{
	snakeTail=snake.shift();
	snakeClean=snakeTail.split(',');
	navigation[snakeClean[0]][snakeClean[1]].value='';
	navigation[snakeClean[0]][snakeClean[1]].style.background="";
}

navigation[snakeX][snakeY].value='snake';
navigation[snakeX][snakeY].style.background="red";

map.childNodes[0].innerHTML="Score:"+score+" Speed:"+speed;
if(!apple){createApple();}

//збільшення швидкості
cherryTimer--;	
speedCounter++;
//console.log(snakeSpeed);
//console.log(speedCounter);
if(speedCounter>10+score){
	
	speed++;
	snakeSpeed=snakeSpeed-(snakeSpeed/10);
	speedCounter=0;
	clearInterval(timerId);
	timerId=setInterval(game, snakeSpeed);
	//console.log(snakeSpeed);
}
//---------------------
}//пауза


}

var timerId=setInterval(game, snakeSpeed);
createMap("map");

addEventListener("keydown", function(event) {
    if (event.keyCode == 32 || event.keyCode == 19){
		 if(!pause)pause=true;else pause=false;
		 console.log(jester);
  }
  });	

 
 
  addEventListener("keydown", function(event) {
    if (event.keyCode == 38 && keyPress==true){
		 up();
  }
  });
  
  addEventListener("keydown", function(event) {
    if (event.keyCode == 40 && keyPress==true){
		down();
	}
  });
  
  addEventListener("keydown", function(event) {
    if (event.keyCode == 37 && keyPress==true){
		left();
	}
  });
  
  addEventListener("keydown", function(event) {
    if (event.keyCode == 39 && keyPress==true){
		right();
	}
		//map.table.style.backgroundColor=("#0f0");
  });
  
 
 
 
 function changeColor(){
		
	};
	var swipeHandler = function(touches, direction){
		if(snakeDirection=="right" || snakeDirection=="left"){
			if(direction === "up" && keyPress==true){
			up();
			return;
			}else if(direction === "down" && keyPress==true){	
			down();
			};	
		}else if(snakeDirection=="up" || snakeDirection=="down"){
			if(direction === "right" && keyPress==true)
			{
				right();
			}else if(direction === "left" && keyPress==true){	
				left();
			}
		}
			
  };
		jester(wrapper, { swipeDistance: 10, preventDefault: true })
		.tap(changeColor)
		.swipe(swipeHandler)



	
}




function menu(){
	highscoreTable(-1);
	map.innerHTML = " <h1>Snake</h1><button onclick='snakeGame()'>Start</button> <button onclick='highscoreTable()'>Highscore</button> ";
}




menu();
