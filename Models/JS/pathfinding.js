
//AI pathfinding and player tracking

function findPath(hunter, target, i){
   
    //if player is above or level with zombie
            if (hunter.y >= target.y){
                
                //player is aligned or left of zombie
                if(hunter.x >= target.x){
                //try moving left 
                zMoveLeft(hunter);
                 //if stuck move right
                 if(hunter.collide(obstacles[i])){
                     hunter.speedX = 0;
                     zMoveRight(hunter);
                     //if stuck move down
                     if(hunter.collide(obstacles[i])){
                         zMoveDown(hunter);
                     }
                   }
                    //if player is right of zombie
                } else if(hunter.x <= target.x){
                    //try moving right
                    zMoveRight(hunter);
                     //if stuck move left
                     if(hunter.collide(obstacles[i])){
                         hunter.speedX = 0;
                         zMoveLeft(hunter);
                         //if stuck move down
                         if(hunter.collide(obstacles[i])){
                             zMoveDown(hunter);
                         }
                     }
                  }  
            }
           
    //if player is below zombie 
            if (hunter.y < target.y){
                
              //player is aligned with or left of zombie
                if(hunter.x >= target.x){
                //try moving left 
                zMoveLeft(hunter);
                 //if stuck move right
                 if(hunter.collide(obstacles[i])){
                     hunter.speedX = 0;
                     zMoveRight(hunter);
                     //if stuck move up
                     if(hunter.collide(obstacles[i])){
                         zMoveUp(hunter);
                     }
                    }
            
              //if player is right of zombie
            }else if(hunter.x <= target.x){
                //try moving right
                zMoveRight(hunter);
                 //if stuck move left
                 if(hunter.collide(obstacles[i])){
                     hunter.speedX = 0;
                     zMoveLeft(hunter);
                     //if stuck move up
                     if(hunter.collide(obstacles[i])){
                         zMoveUp(hunter);
                     }
                 }
              }
            }
            
    //if player is aligned with or left of zombie
            if (hunter.y >= target.y){
                
                //player is aligned or left of zombie
                if(hunter.x >= target.x){
                //try moving left 
                zMoveLeft(hunter);
                 //if stuck move right
                 if(hunter.collide(obstacles[i])){
                     hunter.speedX = 0;
                     zMoveRight(hunter);
                     //if stuck move down
                     if(hunter.collide(obstacles[i])){
                         zMoveDown(hunter);
                     }
                   }
                    //if player is right of zombie
                }else if(hunter.x <= target.x){
                    //try moving right
                    zMoveRight(hunter);
                     //if stuck move left
                     if(hunter.collide(obstacles[i])){
                         hunter.speedX = 0;
                         zMoveLeft(hunter);
                         //if stuck move down
                         if(hunter.collide(obstacles[i])){
                             zMoveDown(hunter);
                         }
                     }
                  }  
            }
        //if palyer is right of zombie
    
};
