on({x:0,y:1,z:0,start:0, color:"r"});//    on(0, 1, 0, 0, "r");

    arr = new Array();
    for (x = 0; x < 8; x++) {
        for (y = 0; y < 8; y++) {
            var pos = {X: x + 1, Z: y + 1};
            arr.push(pos);
        }
    }


    while (arr.length != 0) {

        rnd = Math.floor((Math.random() * arr.length));
        position = arr[rnd];
        arr.splice(rnd, 1);

        rnd2 = Math.floor((Math.random() * arr.length));
        position2 = arr[rnd2];
        arr.splice(rnd2, 1);

        rnd3 = Math.floor((Math.random() * arr.length));
        position3 = arr[rnd3];
        arr.splice(rnd3, 1);

        rnd4 = Math.floor((Math.random() * arr.length));
        position4 = arr[rnd4];
        arr.splice(rnd4, 1);

       off({x:position.X ,y:1 , z:position.Z });// off(position.X, 1, position.Z, 0);
        off({x:position2.X ,y:1 , z:position2.Z });//off(position2.X, 1, position2.Z, 0);
        off({x:position3.X ,y:1 , z:position3.Z });//off(position3.X, 1, position3.Z, 0);
        off({x:position4.X ,y:1 , z:position4.Z });//off(position4.X, 1, position4.Z, 0);
      
        for (z = 1; z < 8; z++) {
         on({x:position.X , y:z , z:position.Z ,start:0.09, stop:0.09, color:"g"});//   on(position.X, z, position.Z, 0.09, "g", 0.08);
          on({x:position2.X,y:z , z:position2.Z ,start:0.09, stop:0.09, color:"g"});//   on(position2.X, z, position2.Z, 0.09, "g", 0.08);
           on({x:position3.X ,y:z , z:position3.Z ,start:0.09, stop:0.09, color:"g"});//  on(position3.X, z, position3.Z, 0.09, "g", 0.08);
           on({x:position4.X ,y:z , z:position4.Z ,start:0.09,stop:0.09, color:"g"});// on(position4.X, z, position4.Z, 0.09, "g", 0.08);
        }

         on({x:position.X ,y:8 , z:position.Z ,start:0.09, color:"g"});//on(position.X, 8, position.Z, 0.09, "b");
        on({x:position2.X ,y:8 , z:position2.Z ,start:0.09, color:"g"});//on(position2.X, 8, position2.Z, 0.09, "b");
        on({x:position3.X ,y:8 , z:position3.Z ,start:0.09, color:"g"});//on(position3.X, 8, position3.Z, 0.09, "b");
        on({x:position4.X ,y:8 , z:position4.Z ,start:0.09, color:"g"});//on(position4.X, 8, position4.Z, 0.09, "b");



   }

    for (y = 8; y > 0; y--)
    {
        if (y != 1) {
           on({x:0 ,y:y , z:0 ,start:0.2, stop:0.2, color:"r"});//  on(0, y, 0, 0.2, "r", 0.2);
        } else
        {
           on({x:0 ,y:y , z:0 ,start:0.2,color:"r"});//  on(0, y, 0, 0.2, "r");
        }
    }

    for (z = 8; z > 1; z--)
    {
        if (z != 1) {
           on({x:0 ,y:1 , z:z ,start:0.2, stop:0.2 ,color:"r"});//  on(0, 1, z, 0.2, "r", 0.2);
        } else {
          on({x:0 ,y:1 , z:z ,start:0.2, color:"r"});//   on(0, 1, z, 0.2, "r");
        }
    }


    for (x = 8; x > 0; x--)
    {
        on({x:x ,y:1 , z:1 ,start:0.2, stop:0.2, color:"r"});// off(x, 1, 1, 0.2, "r", 0.2);
    }



    on({x:1 ,y:1 , z:1 ,start:0.2, color:"b"}); //on( 1-1", "1-1", "1-1", 0.2, "b");
      on({x: 1:2 ,y: 1:2 , z: 1:2 ,start:0.2, color:"b"});//on("1-2", "1-2", "1-2", 0.2, "b");
      on({x: 1:3 ,y: 1:3 , z: 1:3 ,start:0.2, color:"b"});//on("1-3", "1-3", "1-3", 0.2, "b");
      on({x: 1:4 ,y: 1:4 , z: 1:4 ,start:0.2, color:"b"});//on("1-4", "1-4", "1-4", 0.2, "b");
      on({x: 1:5 ,y: 1:5 , z: 1:5 ,start:0.2, color:"b"});//on("1-5", "1-5", "1-5", 0.2, "b");
      on({x: 1:6 ,y: 1:6 , z: 1:6 ,start:0.2, color:"b"});//on("1-6", "1-6", "1-6", 0.2, "b");
      on({x: 1:7 ,y: 1:7 , z: 1:7 ,start:0.2, color:"b"});//on("1-7", "1-7", "1-7", 0.2, "b");
      on({x:0 ,y:0 , z:0 ,start:0.2, color:"b"});//on("1-8", "1-8", "1-8", 0.2, "b");


      on({x:8 ,y:8 , z:8 ,start:0.2, color:"g"});//on("8-8", "8-8", "8-8", 0.2, "g");
    on({x: 7:8 ,y: 7:8 , z: 7:8 ,start:0.2, color:"g"});//on("7-8", "7-8", "7-8", 0.2, "g");
     on({x: 6:8 ,y: 6:8 , z: 6:8 ,start:0.2, color:"g"});//on("6-8", "6-8", "6-8", 0.2, "g");
     on({x: 5:8  ,y: 5:8  , z: 5:8  ,start:0.2, color:"g"});//on("5-8", "5-8", "5-8", 0.2, "g");
     on({x: 4:8 ,y: 4:8 , z: 4:8 ,start:0.2, color:"g"});//on("4-8", "4-8", "4-8", 0.2, "g");
     on({x: 3:8 ,y: 3:8 , z: 3:8 ,start:0.2, color:"g"});//on("3-8", "3-8", "3-8", 0.2, "g");
     on({x: 2:8 ,y: 2:8 , z: 2:8 ,start:0.2, color:"g"});//on("2-8", "2-8", "2-8", 0.2, "g");
     on({x:0 ,y:0 , z:0 ,start:0.2, color:"g"});//on("1-8", "1-8", "1-8", 0.2, "g");

     on({x:8 ,y:1 , z:1 ,start:0.2, color:"r"});//on("8-8", "1-1", "1-1", 0.2, "r");
     on({x: 7:8 ,y: 1:2 , z: 1:2 ,start:0.2, color:"r"});//on("7-8", "1-2", "1-2", 0.2, "r");
    on({x: 6:8 ,y: 1:3 , z: 1:3 ,start:0.2, color:"r"});//on("6-8", "1-3", "1-3", 0.2, "r");
    on({x: 5:8 ,y: 1:4  , z: 1:4 ,start:0.2, color:"r"});//on("5-8", "1-4", "1-4", 0.2, "r");
    on({x: 4:8 ,y: 1:5 , z: 1:5 ,start:0.2, color:"r"});//on("4-8", "1-5", "1-5", 0.2, "r");
    on({x: 3:8 ,y: 1:6 , z: 1:6 ,start:0.2, color:"r"});//on("3-8", "1-6", "1-6", 0.2, "r");
    on({x: 2:8 ,y: 1:7 , z: 1:7 ,start:0.2, color:"r"});//on("2-8", "1-7", "1-7", 0.2, "r");
    on({x:0 ,y:0 , z:0 ,start:0.2, color:"r"});//on("1-8", "1-8", "1-8", 0.2, "r");

   off({x:1 ,y:8 , z:1 ,start:0.2}); //off(1, 8, 1, 0.2);
   off({x: 1:2 ,y: 7:8 , z: 1:2 ,start:0.2});// off("1-2", "7-8", "1-2", 0.2);
      off({x: 1:3 ,y: 6:8 , z: 1:3 ,start:0.2});//off("1-3", "6-8", "1-3", 0.2);
      off({x: 1:4 ,y: 5:8 , z: 1:4 ,start:0.2});//off("1-4", "5-8", "1-4", 0.2);
      off({x: 1:5 ,y: 4:8 , z: 1:5 ,start:0.2});//off("1-4", "4-8", "1-5", 0.2);
      off({x: 1:6 ,y: 3:8 , z: 1:6 ,start:0.2});//off("1-6", "3-8", "1-6", 0.2);
      off({x: 1:7 ,y: 2:8 , z: 1:7 ,start:0.2});//off("1-7", "2-8", "1-7", 0.2);
      off({x:0 ,y:0 , z:0 ,start:0.2});//off("1-8", "1-8", "1-8", 0.2);




    for (y = 8; y > 0; y--) {
        on({x:2 ,y:0 , z:y ,start:0.3, stop:0.2, color:"r"});//on(2, 0, y, 0.3, "r", 0.2);
        on({x: 3:6 ,y:8 , z:y ,start:0, stop:0.2, color:"r"});//on("3-6", 8, y, 0, "r", 0.2);
        on({x:6 ,y: 5:8 , z:y ,start:0, stop:0.2, color:"r"});//on(6, "5-8", y, 0, "r", 0.2);
        on({x: 3:6 ,y:5 , z:y ,start:0, stop:0.2, color:"r"});//on("3-6", 5, y, 0, "r", 0.2);

    }

//off(0,0,0,0.01);
    for (y = 8; y > 0; y--) {
      on({x:2 ,y:0 , z:y ,start:0.3, stop:0.2, color:"r"});//  on(2, 0, y, 0.3, "r", 0.2);
      on({x: 3:6 ,y:8 , z:y ,start:0, stop:0.2, color:"r"});//  on("3-6", 8, y, 0, "r", 0.2);
      on({x: 3:6 ,y:5 , z:y ,start:0, stop:0.2 ,color:"r"});//  on("3-6", 5, y, 0, "r", 0.2);
      on({x: 3:6 ,y:1 , z:y ,start:0, stop:0.2, color:"r"});//  on("3-6", 1, y, 0, "r", 0.2);
    }
//off(0,0,0,0.01);
    for (y = 8; y > 0; y--) {
      on({x:5 ,y:0 , z:y ,start:0.3, stop:0.2 ,color:"r"});//  on(5, 0, y, 0.3, "r", 0.2);
      on({x: 2:7 ,y:8 , z:y ,start:0, stop:0.2, color:"r"});//  on("2-7", 8, y, 0, "r", 0.2);

    }
//off(0,0,0,0.01);
    for (y = 8; y > 0; y--) {
        on({x:2 ,y:0 , z:y ,start:0.3, stop:0.2 ,color:"r"});//on(2, 0, y, 0.3, "r", 0.2);
        on({x: 3:6 ,y:8 , z:y ,start:0, stop:0.2, color:"r"});//on("3-6", 8, y, 0, "r", 0.2);
        on({x: 3:6 ,y:5 , z:y ,start:0, stop:0.2 ,color:"r"});//on("3-6", 5, y, 0, "r", 0.2);
        on({x: 3:6 ,y:1 , z:y ,start:0, stop:0.2 ,color:"r"});//on("3-6", 1, y, 0, "r", 0.2);

//off(0,0,0,0.01);
    }

    for (y = 8; y > 0; y--) {
     on({x:2 ,y:0 , z:y ,start:0.3, stop:0.2, color:"r"});//   on(2, 0, y, 0.4, "r", 0.2);
     on({x: 3:6 ,y:8 , z:y ,start:0, stop:0.2, color:"r"});//   on("3-6", 8, y, 0, "r", 0.2);
     on({x:6 ,y: 5:8 , z:y ,start:0, stop:0.2, color:"r"});//   on(6, "5-8", y, 0, "r", 0.2);
     on({x: 3:6 ,y:5, z:y ,start:0, stop:0.2, color:"r"});//   on("3-6", 5, y, 0, "r", 0.2);
//on(6,4:8,y,0,"r",0.2);
        on({x:3 ,y:4 , z:y ,start:0, stop:0.2, color:"r"});//on(3, 4, y, 0, "r", 0.2);
        on({x:4 ,y:3 , z:y ,start:0, stop:0.2 ,color:"r"});//on(4, 3, y, 0, "r", 0.2);
        on({x:5 ,y:2 , z:y ,start:0, stop:0.2, color:"r"});//on(5, 2, y, 0, "r", 0.2);
        on({x:6 ,y:1 , z:y ,start:0, stop:0.2, color:"r"});//on(6, 1, y, 0, "r", 0.2);
    }

 //delay = 0;