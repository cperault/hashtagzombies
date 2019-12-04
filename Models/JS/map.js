function drawMap(mapHeight, mapWidth, blockH, blockW, obstacles, mapArray, images){
    var mapIndex = 0;
        for (var y = 0; y <= mapHeight-1; y++) {
          for (var x = 0; x <= mapWidth-1; x++, mapIndex++) {
            var tile_x = x * blockW;
            var tile_y = y * blockH;
            var tileType = mapArray[mapIndex];
            if (tileType === 1) {
              obstacles.push(
                new component(images[0], 0, 0, 32, 32, tile_x, tile_y, 32, 32, "tile")
              );
            } else if (tileType === 0) {
                floor.push(
                new component(images[1], 0, 0, 32, 32, tile_x, tile_y, 32, 32, "tile")
                );
                var r = Math.random() * 100;
                if(r >= 98){
                    obstacles.push(
                            new component(images[2], 0, 0, 32, 32, tile_x + 8, tile_y + 8, 16, 16, "med"));
                } else if (r > 0 && r < 3){
                    obstacles.push(
                            new component(images[3], 0, 0, 32, 32, tile_x + 8, tile_y + 8, 16, 16, "food"));
                }
            }    
//              
          }
        
        }
    }