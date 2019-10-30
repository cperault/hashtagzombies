var Player = function(horiz, vert) {
  this.moveHoriz = 300;
  this.moveVert = 550;
  this.counter = 0;
};
Player.prototype.moveLeft = function(speed) {
  if (
    processingInstance.__keyPressed &&
    processingInstance.keyCode === processingInstance.LEFT
  ) {
    this.moveHoriz -= speed;
  } else if (
    processingInstance.__keyPressed &&
    processingInstance.keyCode === processingInstance.DOWN
  ) {
    this.moveVert += speed;
  } else if (
    processingInstance.__keyPressed &&
    processingInstance.keyCode === processingInstance.RIGHT
  ) {
    this.moveHoriz += speed;
  } else if (
    processingInstance.__keyPressed &&
    processingInstance.keyCode === processingInstance.UP
  ) {
    this.moveVert -= speed;
  }
};
Player.prototype.moveRight = function(speed) {};
Player.prototype.moveUp = function(speed) {};
Player.prototype.moveDown = function(speed) {};
Player.prototype.draw = function() {
  processingInstance.fill(0, 0, 0);
  processingInstance.rect(this.moveHoriz - 5, this.moveVert - 15, 5, 15);
  processingInstance.fill(255, 255, 255);
  processingInstance.ellipse(this.moveHoriz, this.moveVert, 15, 15);
};

Player.prototype.shoot = function() {
  /*if(processingInstance.__keyPressed && processingInstance.keyCode === UP){
        if(this.counter === 20){
            rounds.push(new Bullet(2, moveHoriz, 550));
            this.counter = 0;
        }
        this.counter++;
    }*/
};
