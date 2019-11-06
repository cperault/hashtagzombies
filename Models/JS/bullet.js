var Bullet = function(speed, xPos, yPos, dir) {
  this.speed = speed;
  //this.type = type;
  this.xPos = xPos;
  this.yPos = yPos;
  this.dir = dir;
};
Bullet.prototype.fire = function(rounds) {
  switch(this.dir){
    case 37:
        processingInstance.fill(255, 0, 0);
        this.xPos -= this.speed;
        processingInstance.ellipse(this.xPos, this.yPos, 5, 5);
        if (this.yPos <= 0) {
          rounds.shift();
        }
      break;
    case 39:
        processingInstance.fill(255, 0, 0);
        this.xPos += this.speed;
        processingInstance.ellipse(this.xPos, this.yPos, 5, 5);
        if (this.yPos <= 0) {
          rounds.shift();
        }
      break;
    case 40:
        processingInstance.fill(255, 0, 0);
        this.yPos += this.speed;
        processingInstance.ellipse(this.xPos, this.yPos, 5, 5);
        if (this.yPos <= 0) {
          rounds.shift();
        }
      break;
    case 38:
    
        ctx = gameArea.context;
        ctx.fillStyle = "red";
        ctx.fillRect(this.x, this.y, this.width, this.height);
      
      break;
  }
  
};
