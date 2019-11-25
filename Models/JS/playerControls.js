    function moveUp() {
        playerSprite.speedY -= 1;
        playerSprite.sx = 0;
        dir = 87;
      }
      function moveDown() {
        playerSprite.speedY += 1;
        playerSprite.sx = 32;
        dir = 83;
      }
      function moveLeft() {
        playerSprite.speedX -= 1;
        playerSprite.sx = 96;
        dir = 65;
      }
      function moveRight() {
        playerSprite.speedX += 1;
        playerSprite.sx = 64;
        dir = 68;
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


