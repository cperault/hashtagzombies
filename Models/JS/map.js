
      var playerSprite;
      var wallTile;
      var floorTile;
      var floor = [];
      var obstacles = [];
      var enemies = [];
      var blockW = 32;
      var blockH = 32;
      var CWIDTH = 1200;
      var CHEIGHT = 800;
      //make map
      // comment below prevents formatting from messing up the 25x20 map matrix
      // prettier-ignore
      var map = [
              0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
              0,0,0,1,0,0,0,0,0,1,1,1,1,1,1,1,0,0,0,0,0,0,0,1,0,
              0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0,
              0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0,
              0,0,0,1,0,0,0,1,0,0,0,0,0,1,1,1,1,1,1,1,1,0,0,1,0,
              0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0,
              0,1,0,0,0,0,0,1,0,0,1,1,1,1,1,1,1,0,0,0,1,0,0,1,0,
              0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0,
              0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,
              0,1,0,0,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,1,0,
              0,0,0,0,1,0,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,
              0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,
              0,0,0,0,1,0,0,0,1,1,1,0,0,0,1,0,0,0,0,1,0,0,1,0,0,
              0,0,0,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,1,1,0,0,1,0,0,
              0,0,1,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,
              0,0,1,0,1,0,1,0,1,0,0,0,0,1,1,1,1,0,0,0,1,0,1,0,0,
              0,0,1,0,1,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,
              0,0,1,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,
              0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
              0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
              ];
      function startGame() {
        gameArea.start();
        //player
        var playerSpriteImage = new Image();
        playerSpriteImage.src = "Media/Sprites/KevinHumanman.png";
        playerSprite = new component(playerSpriteImage, 32, 65, 32, 32, 32, 32, 32, 32, "player");
        var floorTileImage = new Image();
        floorTileImage.src = "Media/Sprites/FloorTile1.bmp";
        var wallTileImage = new Image();
        wallTileImage.src = "Media/Sprites/WallTile1.bmp";
        var foodSpriteImage = new Image();
        foodSpriteImage.src = "Media/Sprites/borger.png";
        var medSpriteImage = new Image();
        medSpriteImage.src = "Media/Sprites/meds.png";
        //map elements
        var mapIndex = 0;
        for (var y = 0; y <= 19; y++) {
          for (var x = 0; x <= 24; x++, mapIndex++) {
            var tile_x = x * blockW;
            var tile_y = y * blockH;
            var tileType = map[mapIndex];
            if (tileType === 1) {
              obstacles.push(
                new component(wallTileImage, 0, 0, 32, 32, tile_x, tile_y, 32, 32, "tile")
              );
            } else if (tileType === 0) {
                floor.push(
                new component(floorTileImage, 0, 0, 32, 32, tile_x, tile_y, 32, 32, "tile")
                );
                var r = Math.random() * 100;
                if(r >= 98){
                    obstacles.push(
                            new component(medSpriteImage, 0, 0, 32, 32, tile_x + 8, tile_y + 8, 16, 16, "med"));
                } else if (r > 0 && r < 3){
                    obstacles.push(
                            new component(foodSpriteImage, 0, 0, 32, 32, tile_x + 8, tile_y + 8, 16, 16, "food"));
                }
            }    
//              
          }
        }
      }
      //COMPONENTS
      //sprites
      function component(img, sx, sy, sWidth, sHeight, x, y, width, height, category) {
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
          var crash = false;
          if (
            myleft === otherright &&
            (mytop <= otherbottom && mybottom >= othertop)
          ) {
            crash = "right";
          }
          if (
            myright === otherleft &&
            (mytop <= otherbottom && mybottom >= othertop)
          ) {
            crash = "left";
          }
          if (
            mytop === otherbottom &&
            (myright >= otherleft && myleft <= otherright)
          ) {
            crash = "bottom";
          }
          if (
            mybottom === othertop &&
            (myright >= otherleft && myleft <= otherright)
          ) {
            crash = "top";
          }
          return crash;
        };
      }
      function updateGameArea() {
         
        if (gameArea.key){
        if(gameArea.frameNo < 24){
            gameArea.frameNo += 1;
          } else (gameArea.frameNo = 0);
        
          if ((gameArea.frameNo >=0 && gameArea.frameNo <= 6) || (gameArea.frameNo >=13 && gameArea.frameNo <= 18)){
            playerSprite.sy = 64;}
          else if(gameArea.frameNo >= 7 && gameArea.frameNo <= 12){
            playerSprite.sy = 32;
          }
          else {
            playerSprite.sy = 0;
          }
         }
         else {
             playerSprite.sy = 64;
         }
          playerSprite.speedX = 0;
          playerSprite.speedY = 0;
          moveKeys();
          
          //COLLISION CHECK LOGIC
          var collisionCheck = false;
          var c = 0;
          do {
              collisionCheck = playerSprite.collide(obstacles[c]);
              c++;
          }
          while (collisionCheck === false && c < obstacles.length);
        
        if(collisionCheck !== false){
          if (
            collisionCheck === "top" ||
            playerSprite.y >= CHEIGHT - blockH
          ) {
            if (gameArea.key && (gameArea.key === 40 || gameArea.key === 83)) {
              stopMove();
            }
          }if (
            collisionCheck === "bottom" ||
            playerSprite.y <= 0
          ) {
             if (gameArea.key && (gameArea.key === 38 || gameArea.key === 87)) {
              stopMove();
            }
          }if (
            collisionCheck === "left" ||
            playerSprite.x >= CWIDTH - blockW
          ) {
            if (gameArea.key && (gameArea.key === 39 || gameArea.key === 68)) {
              stopMove();
            }
          }if (
            collisionCheck === "right" ||
            playerSprite.x <= 0
          ) {
            if (gameArea.key && (gameArea.key === 37 || gameArea.key === 65)) {
              stopMove();
            }
          }
          if (obstacles[c].category === "med" || obstacles[c].category === "food"){
              if (gameArea.key && gameArea.key === 71){
                    obstacles.splice(c, 1);
              }
          }
        }
          gameArea.clear();
          for (var f = 0; f < floor.length; f++){
              floor[f].update();
          }
          for (var b = 0; b < obstacles.length; b++){
              obstacles[b].update();
          }
          playerSprite.newPos();
          playerSprite.update();
          }
      var gameArea = {
        canvas: document.createElement("canvas"),
        start: function() {
          this.canvas.width = CWIDTH;
          this.canvas.height = CHEIGHT;
          this.context = this.canvas.getContext("2d");
          document.body.insertBefore(this.canvas, document.body.childNodes[0]);
          this.frameNo = 0;
          //FRAMERATE
          this.interval = setInterval(updateGameArea, 40);
          window.addEventListener("keydown", function(e) {
            gameArea.key = e.keyCode;
          });
          window.addEventListener("keyup", function(e) {
            gameArea.key = false;
          });
        },
        clear: function() {
          this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
        }
      };
      //player movement controls
      function moveUp() {
        playerSprite.speedY -= 1;
        playerSprite.sx = 0;
   
      }
      function moveDown() {
        playerSprite.speedY += 1;
        playerSprite.sx = 32;
      }
      function moveLeft() {
        playerSprite.speedX -= 1;
        playerSprite.sx = 96;
      }
      function moveRight() {
        playerSprite.speedX += 1;
        playerSprite.sx = 64;
      }
      function stopMove() {
        playerSprite.speedY = 0;
        playerSprite.speedX = 0;
      }
      
      function moveKeys(){
           if (gameArea.key && (gameArea.key === 38 || gameArea.key === 87)) {
              moveUp();
            }
            if (gameArea.key && (gameArea.key === 40 || gameArea.key === 83)) {
              moveDown();
            }
            if (gameArea.key && (gameArea.key === 37 || gameArea.key === 65)) {
              moveLeft();
            }
            if (gameArea.key && (gameArea.key === 39 || gameArea.key === 68)) {
              moveRight();
            }
            if(!gameArea.key){
                stopMove();
            }
      }
