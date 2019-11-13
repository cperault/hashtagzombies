var Bullet = function(speed, xPos, yPos, dir, width, height) {
  this.speed = speed;
  this.xPos = xPos;
  this.yPos = yPos;
  this.dir = dir;
  this.width = width;
  this.height = height;
};
Bullet.prototype.collide = function(otherobj) {
  for (var i = 0; i < otherobj.length; i++){
  var myleft = this.xPos;
  var myright = this.xPos + this.width;
  var mytop = this.yPos;
  var mybottom = this.yPos + this.height;
  var otherleft = otherobj[i].x;
  var otherright = otherobj[i].x + otherobj[i].width;
  var othertop = otherobj[i].y;
  var otherbottom = otherobj[i].y + otherobj[i].height;

  if (myleft >= otherleft && myright <= otherright && mytop >= othertop && mybottom <= otherbottom){
    return true;
  }
  }
  return false;

};