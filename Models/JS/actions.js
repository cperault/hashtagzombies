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
    var game = "menu";
    var s = [];
    var sRounds = [];
    var money = 2000;
    var player;
    var fireType;
    var counter = 0;
    var hit = 0;
    var zombType = ["Normal", "Crawler", "Big"];
    var item;
    var player = new Player(550, 300);
    var Bullet = function(speed, xPos, yPos) {
      this.speed = speed;
      //this.type = type;
      this.xPos = xPos;
      this.yPos = yPos;
    };

    var Survivor = function(damage, type, xPos, yPos, range, counter) {
      this.damage = damage;
      this.type = type;
      this.xPos = xPos;
      this.yPos = yPos;
      this.range = range;
      this.maxCounter = counter;
      this.count = 0;
    };
    Survivor.prototype.shoot = function() {
      if (this.count === this.maxCounter) {
        sRounds.push(new Bullet(2, this.xPos, this.yPos));
        this.count = 0;
      }
      this.count++;
    };

    var Zombie = function(health, type, xPos, yPos, speed) {
      this.health = health;
      this.type = type;
      this.xPos = xPos;
      this.yPos = yPos;
      this.speed = speed;
    };

    var Shot = function(xPos, yPos, speed, rounds, distance) {
      this.xPos = xPos;
      this.yPos = yPos;
      this.speed = speed;
      this.rounds = rounds;
      this.distance = distance;
    };
    Shot.prototype.shoot = function() {
      this.yPos -= this.speed;
      ellipse(this.xPos, this.yPos, 5, 5);
    };

    var generate = function() {
      x = [];
      s = [];
      var zombies = 5;
      for (var z = 1; z <= zombies; z++) {
        var health = 10;
        var type = "Normal";
        var xPos = random(10, 550);
        var yPos = 0;
        var speed = random(0.1, 1);
        x.push(new Zombie(health, type, xPos, yPos, speed));
      }
    }; //number of zombies

    var barricade = function() {
      fill(112, 94, 66);
      rect(0, 512, 599, 15);
      stroke(54, 255, 255);
      line(0, 12, 600, 12);
      stroke(0, 0, 0);
      line(0, 112, 600, 112);
      stroke(247, 255, 0);
      line(0, 187, 600, 187);
      stroke(0, 255, 17);
      line(0, 237, 600, 237);
      stroke(255, 0, 0);
      line(0, 412, 600, 412);
      stroke(0, 0, 0);
    };

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
    var howToBtn = new Button({
      x: 457,
      y: 450,
      width: 150,
      label: "How",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "how";
      }
    });
    var store = new Button({
      x: 35,
      y: 565,
      width: 60,
      label: "Store",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "store";
      }
    });
    var buyFlame = new Button({
      x: 335,
      y: 350,
      width: 45,
      label: "Buy",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "flame";
      }
    });
    var buySniper = new Button({
      x: 335,
      y: 406,
      width: 45,
      label: "Buy",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "snipe";
      }
    });
    var buyTank = new Button({
      x: 335,
      y: 456,
      width: 45,
      label: "Buy",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "tank";
      }
    });
    var buyManiac = new Button({
      x: 335,
      y: 511,
      width: 45,
      label: "Buy",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "maniac";
      }
    });
    var buyBasic = new Button({
      x: 335,
      y: 561,
      width: 45,
      label: "Buy",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "basic";
      }
    });
    var back = new Button({
      x: 46,
      y: 44,
      width: 60,
      label: "Back",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "play";
      }
    });
    var pause = new Button({
      x: 37,
      y: 35,
      width: 60,
      label: "| |",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "pause";
      }
    });
    var quite = new Button({
      x: 566,
      y: 35,
      width: 60,
      label: "Menu",
      color: color(99, 97, 54),
      hoverColor: color(197, 204, 96),
      onClick: function() {
        game = "menu";
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
    var surCheckHit = function() {
      for (var j = 0; j < x.length; j++) {
        for (var i = 0; i < sRounds.length; i++) {
          if (
            sRounds[i].xPos >= x[j].xPos - 15 &&
            sRounds[i].xPos <= x[j].xPos + 15 &&
            sRounds[i].yPos >= x[j].yPos - 15 &&
            sRounds[i].yPos <= x[j].yPos + 15
          ) {
            hit = 5;
            x[j].health -= hit;
            sRounds.shift();
          }
        }
      }
    };
    var enemies = function() {
      for (var i = 0; i < x.length; i++) {
        fill(65, 102, 50);
        x[i].yPos += x[i].speed;
        ellipse(x[i].xPos, x[i].yPos, 15, 15);
        //if(x[i].health === 10){
        fill(255, 0, 0);
        rect(x[i].xPos - 5, x[i].yPos - 15, x[i].health, 3);
        // else if(x[i].health === 5) {
        //    fill(255, 0, 0);
        //    rect(x[i].xPos -5, x[i].yPos -15, 5, 3); } else
        if (x[i].health <= 0) {
          x.splice(i, 1);
          i++;
          money += 50;
        }
        //println(i + " " + x[i].health);
      }
    }; //update zombie health and splice from array
    var fire = function() {
      for (var i = 0; i < rounds.length; i++) {
        fill(255, 0, 0);
        rounds[i].yPos -= rounds[i].speed;
        ellipse(rounds[i].xPos, rounds[i].yPos, 5, 5);
        //println(rounds[i].yPos);
        if (rounds[i].yPos <= 0) {
          rounds.shift();
        }
      }
    };
    var surFire = function() {
      for (var i = 0; i < sRounds.length; i++) {
        fill(255, 0, 0);
        sRounds[i].yPos -= sRounds[i].speed;
        ellipse(sRounds[i].xPos, sRounds[i].yPos, 5, 5);
        if (sRounds[i].yPos <= 12) {
          sRounds.shift();
        }
      }
    };
    var menu = function() {
      background(84, 82, 82);
      textSize(50);
      fill(175, 179, 74);
      textFont(createFont("cursive"));
      text("Circle of Life", 141, 100, 339, 110);
      playBtn.draw();
      howToBtn.draw();
      player = new Player();
    };
    var play = function() {
      //var a =round(random(0,(zombType.length-1)));
      //item = zombType[a];
      background(140, 136, 136);
      barricade();
      store.draw();
      pause.draw();
      quite.draw();
      player.draw();
      player.moveLeft(PLAYER_HORZONTAL_SPEED);
      player.moveRight(PLAYER_HORZONTAL_SPEED);
      player.moveUp(PLAYER_HORZONTAL_SPEED);
      player.moveDown(PLAYER_HORZONTAL_SPEED);
      player.shoot();
      text("Money: $" + money, 508, 580);
      for (var i = 0; i < s.length; i++) {
        if (s[i].type === "Sniper") {
          fill(54, 255, 255);
          ellipse(s[i].xPos, 550, 12, 12);
          s[i].shoot();
        }
        if (s[i].type === "Tank") {
          fill(0, 0, 0);
          ellipse(s[i].xPos, 550, 20, 20);
          s[i].shoot();
        }
        if (s[i].type === "Maniac") {
          fill(247, 255, 0);
          ellipse(s[i].xPos, 550, 15, 15);
          s[i].shoot();
        }
        if (s[i].type === "Basic") {
          fill(0, 255, 17);
          ellipse(s[i].xPos, 550, 15, 15);
          s[i].shoot();
        }
        if (s[i].type === "Flame") {
          fill(255, 0, 0);
          ellipse(s[i].xPos, 550, 15, 15);
          s[i].shoot();
        }
      }
      surFire();
      fire();
      enemies();
      checkHit();
      surCheckHit();
      if (x.length === 0) {
        game = "gen";
      }
    };
    var shop = function() {
      background(140, 136, 136);
      textFont(createFont("cursive"));
      fill(255, 255, 255);
      textSize(20);
      text("Weapons", -13, 10, 339, 110);
      text("Survivors", -13, 220, 339, 110);
      text("Barricade Upgrades", 244, 10, 339, 110);
      textSize(15);
      text("Flamethrower $200", 51, 289, 339, 110);
      text("Sniper $300", 51, 344, 339, 110);
      text("Tank $500", 51, 400, 339, 110);
      text("Maniac $250", 51, 451, 339, 110);
      text("Basic Survivor $50", 51, 502, 339, 110);
      fill(255, 0, 0);
      ellipse(109, 349, 15, 15);
      fill(54, 255, 255);
      ellipse(109, 405, 12, 12);
      fill(0, 0, 0);
      ellipse(109, 458, 20, 20);
      fill(247, 255, 0);
      ellipse(109, 511, 15, 15);
      fill(0, 255, 17);
      ellipse(109, 560, 15, 15);
      buyFlame.draw();
      buySniper.draw();
      buyTank.draw();
      buyManiac.draw();
      buyBasic.draw();
      back.draw();
    };
    var how = function() {
      background(140, 136, 136);
      textFont(createFont("cursive"));
      fill(255, 255, 255);
      textSize(20);
      text(
        "Survive against waves of zombies. Use money to buy other survivors, weapons, and to improve your barricade. There are colored lines on the battlefield to tell you the range of weapons and other survivors.",
        125,
        200,
        339,
        210
      );
      quite.draw();
    };

    mouseClicked = function() {
      if (game === "menu") {
        playBtn.handleMouseClick();
        howToBtn.handleMouseClick();
      }
      if (game === "play") {
        store.handleMouseClick();
        quite.handleMouseClick();
      }
      if (game === "charColor") {
      }
      if (game === "store") {
        back.handleMouseClick();
        buyFlame.handleMouseClick();
        buySniper.handleMouseClick();
        buyTank.handleMouseClick();
        buyManiac.handleMouseClick();
        buyBasic.handleMouseClick();
      }
      if (game === "how") {
        quite.handleMouseClick();
      }
    };

    draw = function() {
      switch (game) {
        case "menu":
          menu();
          break;
        case "gen":
          generate();
          game = "play";
          break;
        case "play":
          play();
          break;
        case "how":
          how();
          break;
        case "store":
          shop();
          break;
        case "flame":
          if (money >= 200) {
            var a = random(10, 550);
            s.push(new Survivor(0.5, "Flame", a, 550, 100, 1));
            money -= 200;
            game = "play";
          } else {
            println("You don't have enough money!");
            game = "store";
          }
          break;
        case "snipe":
          if (money >= 300) {
            var a = random(10, 550);
            s.push(new Survivor(15, "Sniper", a, 550, 500, 100));
            money -= 300;
            game = "play";
          } else {
            println("You don't have enough money!");
            game = "store";
          }
          break;
        case "tank":
          if (money >= 500) {
            var a = random(10, 550);
            s.push(new Survivor(6, "Tank", a, 550, 400, 50));
            money -= 500;
            game = "play";
          } else {
            println("You don't have enough money!");
            game = "store";
          }
          break;
        case "maniac":
          if (money >= 250) {
            var a = random(10, 550);
            s.push(new Survivor(4, "Maniac", a, 550, 325, 15));
            money -= 250;
            game = "play";
          } else {
            println("You don't have enough money!");
            game = "store";
          }
          break;
        case "basic":
          if (money >= 50) {
            var a = random(10, 550);
            s.push(new Survivor(2, "Basic", a, 550, 300, 20));
            money -= 50;
            game = "play";
          } else {
            println("You don't have enough money!");
            game = "store";
          }
          break;
      }
    };
  }
};

// Get the canvas that Processing-js will use
var canvas = document.getElementById("canvas");
// Pass the function sketchProc (defined in myCode.js) to Processing's constructor.
var processingInstance = new Processing(canvas, sketchProc);
