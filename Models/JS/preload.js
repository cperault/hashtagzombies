//Set up canvas and game area/parameters

var gameArea = {
        canvas: document.createElement("canvas"),
        start: function() {
          this.canvas.width = CWIDTH;
          this.canvas.height = CHEIGHT;
          this.context = this.canvas.getContext("2d");
          document.body.insertBefore(this.canvas, document.body.childNodes[0]);
          this.frameNo = 0;
          //FRAMERATE
          this.interval = setInterval(updateGameArea, 20);
          window.addEventListener("keydown", function(e) {
            gameArea.key = e.keyCode;
          });
          window.addEventListener("keyup", function(e) {
            gameArea.key = false;
          });
          window.addEventListener("mousedown", function(e) {
            timer = setInterval(function() {
              rounds.push(new Bullet(4, playerSprite.x + 16, playerSprite.y + 16, dir, 3, 3));
            }, 500);
            gameArea.click = true;
          });
          window.addEventListener("mouseup", function(e){
            gameArea.click = false;
            clearInterval(timer);
          });
          window.addEventListener("contextmenu", event => event.preventDefault());
        },
        clear: function() {
          this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
        }
      };
      
//Build sprites   
       function component(img, sx, sy, sWidth, sHeight, x, y, width, height, category, health) {
        this.width = width;
        this.height = height;
        this.x = x;
        this.y = y;
        this.speedX = 0;
        this.speedY = 0;
        this.sx = sx;
        this.sy = sy;
        this.category = category;
        this.health = health;
        this.update = function() {
          ctx = gameArea.context;
          ctx.drawImage(img, this.sx, this.sy, sWidth, sHeight, this.x, this.y, width, height);
        };
        this.newPos = function() {
          this.x += this.speedX;
          this.y += this.speedY;
        };
        this.collide = function(otherobj) {
          var myleft = this.x;
          var myright = this.x + this.width;
          var mytop = this.y;
          var mybottom = this.y + this.height;
          var otherleft = otherobj.x;
          var otherright = otherobj.x + otherobj.width;
          var othertop = otherobj.y;
          var otherbottom = otherobj.y + otherobj.height;
          var crash = [];
          if (
            myleft === otherright &&
            mytop <= otherbottom && mybottom >= othertop
          ) {
            crash.push("right");
          }
          if (
            myright === otherleft &&
            mytop <= otherbottom && mybottom >= othertop
          ) {
            crash.push("left");
          }
          if (
            mytop === otherbottom &&
            myright >= otherleft && myleft <= otherright
          ) {
            crash.push("bottom");
          }
          if (
            mybottom === othertop &&
            myright >= otherleft && myleft <= otherright
          ) {
            crash.push("top");
          }
          return crash;
        };
        this.getCategory = function(){
        category = this.category;
        return category; 
        };
      }
      
      
//build map elements
function environment(img, sx, sy, sWidth, sHeight, x, y, width, height, category) {
        this.width = width;
        this.height = height;
        this.x = x;
        this.y = y;
        this.speedX = 0;
        this.speedY = 0;
        this.sx = sx;
        this.sy = sy;
        this.category = category;
        this.update = function() {
          ctx = gameArea.context;
          ctx.drawImage(img, this.sx, this.sy, sWidth, sHeight, this.x, this.y, width, height);
        };
        this.newPos = function() {
          this.x += this.speedX;
          this.y += this.speedY;
        };
        this.collide = function(otherobj) {
          var myleft = this.x;
          var myright = this.x + this.width;
          var mytop = this.y;
          var mybottom = this.y + this.height;
          var otherleft = otherobj.x;
          var otherright = otherobj.x + otherobj.width;
          var othertop = otherobj.y;
          var otherbottom = otherobj.y + otherobj.height;
          var crash = [];
          if (
            myleft === otherright &&
            mytop <= otherbottom && mybottom >= othertop
          ) {
            crash.push("right");
          }
          if (
            myright === otherleft &&
            mytop <= otherbottom && mybottom >= othertop
          ) {
            crash.push("left");
          }
          if (
            mytop === otherbottom &&
            myright >= otherleft && myleft <= otherright
          ) {
            crash.push("bottom");
          }
          if (
            mybottom === othertop &&
            myright >= otherleft && myleft <= otherright
          ) {
            crash.push("top");
          }
          return crash;
        };
        this.getCategory = function(){
        category = this.category;
        return category; 
        };
      }

