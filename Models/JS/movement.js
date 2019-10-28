var Player = function(horiz, vert){
    this.moveHoriz = 300;
    this.moveVert = 550;
};
Player.prototype.moveLeft = function(speed) {
    if(processingInstance.keyPressed && processingInstance.keyCode === processingInstance.LEFT){
        this.moveHoriz -= speed;
    }
};
Player.prototype.moveRight = function(speed) {
    if(processingInstance.keyPressed && processingInstance.keyCode === processingInstance.RIGHT){
        this.moveHoriz += speed;
    }
};
Player.prototype.moveUp = function(speed) {
    if(processingInstance.keyPressed && processingInstance.keyCode === processingInstance.UP){
        this.moveVert -= speed;
    }
};
Player.prototype.moveDown = function(speed) {
    if(processingInstance.keyPressed && processingInstance.keyCode === processingInstance.DOWN){
        this.moveVert += speed;
    }
};
Player.prototype.draw = function() {
    processingInstance.fill(0, 0, 0);
    processingInstance.rect(this.moveHoriz - 5, this.moveVert -15, 5, 15);
    processingInstance.fill(255, 255, 255);
    processingInstance.ellipse(this.moveHoriz,this.moveVert,15,15);
};

Player.prototype.shoot = function() {
    //if(keyPressed && keyCode === UP){
        //if(counter === 20){
        //rounds.push(new Bullet(2, moveHoriz, 550));
        //counter = 0;
        //}
        //counter++;
    //}
};