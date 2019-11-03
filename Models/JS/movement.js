var Player = function(horiz, vert) {
  this.moveHoriz = 300;
  this.moveVert = 550;
  this.counter = 0;
  this.rectW = 15;
  this.rectH = 3;
  this.rectX = 5;
  this.rectY = 15;
  this.dir;
};
Player.prototype.moveLeft = function(speed, rounds) {
  if (
    processingInstance.__keyPressed &&
    processingInstance.keyCode === processingInstance.LEFT
  ) {
    this.dir = processingInstance.keyCode;
    this.shoot(rounds, this.dir);
    this.moveHoriz -= speed;
    this.rectW = 3;
    this.rectH = 15;
    this.rectX = 15;
    this.rectY = 0;
  }
};
Player.prototype.moveDown = function(speed, rounds) {
  if (
    processingInstance.__keyPressed &&
    processingInstance.keyCode === processingInstance.DOWN
  ) {
    this.dir = processingInstance.keyCode;
    this.shoot(rounds, this.dir);
    this.moveVert += speed;
    this.rectW = 15;
    this.rectH = 3;
    this.rectX = 0;
    this.rectY = 0;
  }
};
Player.prototype.moveUp = function(speed, rounds) {
  if (
    processingInstance.__keyPressed &&
    processingInstance.keyCode === processingInstance.UP
  ) {
    this.dir = processingInstance.keyCode;
    this.shoot(rounds, this.dir);
    this.moveVert -= speed;
    this.rectW = 15;
    this.rectH = 3;
    this.rectX = 5;
    this.rectY = 15;
  }
};
Player.prototype.moveRight = function(speed, rounds) {
  if (
    processingInstance.__keyPressed &&
    processingInstance.keyCode === processingInstance.RIGHT
  ) {
    this.dir = processingInstance.keyCode;
    this.shoot(rounds, this.dir);
    this.moveHoriz += speed;
    this.rectH = 15;
    this.rectW = 3;
    this.rectX = 0;
    this.rectY = 5;
  }
};
Player.prototype.draw = function() {
  processingInstance.fill(0, 0, 0);
  processingInstance.rect(this.moveHoriz - this.rectX, this.moveVert - this.rectY, this.rectH, this.rectW);
  processingInstance.fill(255, 255, 255);
  processingInstance.ellipse(this.moveHoriz, this.moveVert, 15, 15);
};

Player.prototype.shoot = function(rounds) {
    if(processingInstance.__mousePressed){
    //switch(processingInstance.keyCode){
        //case 32:
        if (this.counter === 10) {
          rounds.push(new Bullet(5, this.moveHoriz, this.moveVert, this.dir));
          this.counter = 0;
        }
        this.counter++;
    //}
}
  /*if (processingInstance.__keyPressed && processingInstance.key === 0) {
    if (this.counter === 10) {
      rounds.push(new Bullet(5, this.moveHoriz, this.moveVert, "LEFT"));
      this.counter = 0;
    }
    this.counter++;
  }*/
};
