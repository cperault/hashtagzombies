var sketchProc = function(processingInstance) {
  with (processingInstance) {
    size(1080, 960);
    frameRate(50);

    var PLAYER_HORZONTAL_SPEED = 1;
    var PLAYER_VERTICAL_SPEED = 1;
    var moveHoriz = 300;
    var moveVert = 550;
    var x = [];
    var rounds = [];
    var game = "play";
    var player;
    var counter = 0;
    var hit = 0;
    var player = new Player(550, 300);
    var Button = function(config) {
      this.x = config.x || 200;
      this.y = config.y || 200;
      this.width = config.width || 60;
      this.label = config.label || "Click";
      this.color = config.color || color(112, 83, 83);
      this.hoverColor = config.hoverColor || color(158, 71, 71);
      this.onClick = config.onClick || function() {};
    };
    Button.prototype.draw = function() {
      if (this.isMouseInside()) {
        fill(this.hoverColor);
      } else {
        fill(this.color);
      }
      stroke(0, 0, 0);
      strokeWeight(1);
      ellipseMode(CENTER);
      ellipse(this.x, this.y, this.width, this.width);
      fill(255, 255, 255);
      textSize(20);
      textFont(createFont("Arial Bold"));
      textAlign(CENTER, CENTER);
      text(this.label, this.x, this.y);
    };
    Button.prototype.isMouseInside = function() {
      return dist(mouseX, mouseY, this.x, this.y) < this.width / 2;
    };
    Button.prototype.handleMouseClick = function() {
      if (this.isMouseInside()) {
        this.onClick();
      }
    };

    var playBtn = new Button({
      x: 126,
      y: 450,
      width: 150,
      label: "Play",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "gen";
      }
    });
    var checkHit = function() {
      for (var j = 0; j < x.length; j++) {
        for (var i = 0; i < rounds.length; i++) {
          if (
            rounds[i].xPos >= x[j].xPos - 15 &&
            rounds[i].xPos <= x[j].xPos + 15 &&
            rounds[i].yPos >= x[j].yPos - 15 &&
            rounds[i].yPos <= x[j].yPos + 15
          ) {
            hit = 2;
            x[j].health -= hit;
            rounds.shift();
          }
        }
      }
    };
    var fire = function() {
      for (var i = 0; i < rounds.length; i++) {
        rounds[i].fire(rounds);
      }
    };
    var play = function() {
      //var a =round(random(0,(zombType.length-1)));
      //item = zombType[a];
      background(140, 136, 136);
      player.draw();
      player.moveLeft(PLAYER_HORZONTAL_SPEED, rounds);
      player.moveRight(PLAYER_HORZONTAL_SPEED, rounds);
      player.moveUp(PLAYER_HORZONTAL_SPEED, rounds);
      player.moveDown(PLAYER_HORZONTAL_SPEED, rounds);
      player.shoot(rounds);
      fire();
    };

    mouseClicked = function() {
      if (game === "menu") {
        playBtn.handleMouseClick();
        howToBtn.handleMouseClick();
      }
    };

    draw = function() {
      switch (game) {
        case "play":
          play();
          break;
      }
    };
  }
};

// Get the canvas that Processing-js will use
var canvas = document.getElementById("canvas");
// Pass the function sketchProc (defined in myCode.js) to Processing's constructor.
var processingInstance = new Processing(canvas, sketchProc);
