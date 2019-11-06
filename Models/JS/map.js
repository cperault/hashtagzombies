var spawnrate = 3;
            var playerSprite;
            var obstacles = [];
            var enemies = [];
            var blockW = 32;
            var blockH = 32;
             //make map
              var map = [
              0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
              0,0,0,1,0,0,0,0,0,1,1,1,1,1,1,1,0,0,0,0,0,0,0,1,0,
              0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0,
              0,0,0,1,0,0,0,1,2,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0,
              0,0,0,1,0,0,0,1,0,0,0,0,0,1,1,1,1,1,1,1,1,0,0,1,0,
              0,0,0,1,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0,
              0,1,0,0,0,0,0,1,0,0,1,1,1,1,1,1,1,0,0,0,1,0,0,1,0,
              0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,1,0,
              0,1,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,
              0,1,0,0,1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,1,0,
              0,0,0,0,1,0,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0,
              0,0,0,0,1,0,0,0,3,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,
              0,0,0,0,1,0,0,0,1,1,1,0,0,0,1,0,0,0,0,1,0,0,1,0,0,
              0,0,0,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,1,1,0,0,1,0,0,
              0,0,1,0,1,0,1,0,1,0,0,0,0,0,0,0,0,0,1,0,0,0,1,0,0,
              0,0,1,0,1,0,1,0,1,0,0,0,0,1,1,1,1,0,0,0,1,0,1,0,0,
              0,0,1,0,1,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,
              0,0,1,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,
              0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,4,0,0,0,0,0,0,
              0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
              ];
              
              
            function startGame(){
                gameArea.start();
                 //player
                playerSprite = new component(16, 16, "blue", 32, 32);
                //map elements
                var mapIndex = 0;
                for (var y = 0; y <= 19; y++){
                    for (var x = 0; x <=24; x++, mapIndex++){
                        
                        var tile_x = x * blockW;
                        var tile_y = y * blockH;
                        
                        var tileType = map[mapIndex];
                         if (tileType === 1){
                            obstacles.push(new component(blockW, blockH, "black", tile_x, tile_y));
                        }
                        else if(tileType === 2){
                            obstacles.push(new component(blockW/2, blockH/2, "green", tile_x, tile_y));
                        }
                        else if(tileType === 3){
                            obstacles.push(new component(blockW/2, blockH/2, "pink", tile_x, tile_y));
                        }
                        else if (tileType === 4) {
                            obstacles.push(new component(blockW/2, blockH/2, "yellow", tile_x, tile_y));
                        }
                    }
                }
            }  
            
             //COMPONENTS
            //sprites
            function component(width, height, color, x, y) {
                this.width = width;
                this.height = height;
                this.x = x;
                this.y = y;
                this.speedX = 0;
                this.speedY = 0;
                this.update=function(){
                    ctx = gameArea.context;
                    ctx.fillStyle = color;
                    ctx.fillRect(this.x, this.y, this.width, this.height);
                };
                this.newPos = function(){
                    this.x += this.speedX;
                    this.y += this.speedY;
                };
                this.collide= function(otherobj){
                    var myleft = this.x;
                    var myright = this.x + (this.width);
                    var mytop = this.y;
                    var mybottom = this.y + (this.height);
                    var otherleft = otherobj.x;
                    var otherright = otherobj.x + (otherobj.width);
                    var othertop = otherobj.y;
                    var otherbottom = otherobj.y + (otherobj.height);
                    var crash = false;
                    
                    if (myleft === otherright && (mytop <= otherbottom && mybottom >= othertop)){
                        crash = "right";
                    }
                    if (myright === otherleft && (mytop <= otherbottom && mybottom >= othertop)){
                        crash = "left";
                    }
                    if (mytop === otherbottom && (myright >= otherleft && myleft <= otherright)){
                        crash = "bottom";
                    }
                    if (mybottom === othertop && (myright >= otherleft && myleft <= otherright)){
                        crash = "top";
                    }
                    
                    return crash;
                  }
                } 
                
             
            
              function updateGameArea(){
                   for (i = 0; i < obstacles.length; i++){
                        if (playerSprite.collide(obstacles[i]) === "top"){
                          gameArea.clear();
                          playerSprite.speedX = 0;
                          playerSprite.speedY = 0;
                          if (gameArea.key && (gameArea.key === 38 || gameArea.key === 87)){ moveUp();}
                          if(gameArea.key && (gameArea.key === 37 || gameArea.key === 65)){ moveLeft();}
                          if(gameArea.key && (gameArea.key === 39 || gameArea.key === 68)) { moveRight();}
                          
//                              for (i = 0; i < enemies.length; i++){
//                                 enemies[i].update();
//                             }
                        }
                        else if (playerSprite.collide(obstacles[i]) === "bottom"){
                          gameArea.clear();
                          playerSprite.speedX = 0;
                          playerSprite.speedY = 0;
                          if(gameArea.key && (gameArea.key === 40 || gameArea.key === 83)){ moveDown();}
                          if(gameArea.key && (gameArea.key === 37 || gameArea.key === 65)){ moveLeft();}
                          if(gameArea.key && (gameArea.key === 39 || gameArea.key === 68)) { moveRight();}
                          
                        }
                        else if (playerSprite.collide(obstacles[i]) === "left"){
                          gameArea.clear();
                          playerSprite.speedX = 0;
                          playerSprite.speedY = 0;
                          if (gameArea.key && (gameArea.key === 38 || gameArea.key === 87)){ moveUp();}
                          if(gameArea.key && (gameArea.key === 40 || gameArea.key === 83)){ moveDown();}
                          if(gameArea.key && (gameArea.key === 37 || gameArea.key === 65)){ moveLeft();}
                      }
                          
                        else if(playerSprite.collide(obstacles[i]) === "right"){
                          gameArea.clear();
                          playerSprite.speedX = 0;
                          playerSprite.speedY = 0;
                          if(gameArea.key && (gameArea.key === 38 || gameArea.key === 87)){ moveUp();}
                          if(gameArea.key && (gameArea.key === 40 || gameArea.key === 83)){ moveDown();}
                          if(gameArea.key && (gameArea.key === 39 || gameArea.key === 68)) { moveRight();}
                          
                        }
                      else {
                      gameArea.clear();
                      playerSprite.speedX = 0;
                      playerSprite.speedY = 0;
                      if(gameArea.key && (gameArea.key === 38 || gameArea.key === 87)){ moveUp();}
                      if(gameArea.key && (gameArea.key === 40 || gameArea.key === 83)){ moveDown();}
                      if(gameArea.key && (gameArea.key === 37 || gameArea.key === 65)){ moveLeft();}
                      if(gameArea.key && (gameArea.key === 39 || gameArea.key === 68)) {moveRight();}  
                      }
                       
                       playerSprite.newPos();
                       playerSprite.update();
                       for (i = 0; i <obstacles.length; i++){
                              obstacles[i].update();
                             }
                      }
                   
            }
            
            var WIDTH=1200;
            var HEIGHT=800;
            var gameArea = {
                canvas : document.createElement("canvas"),
                start : function (){
                    this.canvas.width = WIDTH;
                    this.canvas.height = HEIGHT;
                    this.context = this.canvas.getContext("2d");
                    document.body.insertBefore(this.canvas, document.body.childNodes[0]);
                    this.frameNo = 0;
                    //FRAMERATE
                    this.interval = setInterval(updateGameArea, 40);
                    window.addEventListener('keydown', function (e) {
                        gameArea.key = e.keyCode;
                    });
                    window.addEventListener('keyup', function(e){
                        gameArea.key = false;
                    });
                },
                clear: function() {
                    this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
                }
            };
 
            //player movement controls
                function moveUp(){
                    playerSprite.speedY -= 1;
                }
                function moveDown(){
                    playerSprite.speedY += 1;
                }
                function moveLeft(){
                    playerSprite.speedX -= 1;
                }
                function moveRight() {
                    playerSprite.speedX += 1;
                }
                function stopMove(){
                    playerSprite.speedY = 0;
                    playerSprite.speedX = 0;
                }
                
            
           
            
            