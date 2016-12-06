model Hydraulika
  constant Real q1=0 "pritok1";
  constant Real q2=0 "pritok2";
  constant Real q3=0 "pritok3";
  constant Real ro=1 "hustota";
  constant Real g=9.81 "gravitacne zrychlenie";
  constant Real R1=8000 "hodpor1";
  constant Real R2=8000 "hodpor2";
  constant Real R3=8000 "hodpor3";
  constant Real F1=0.00785 "prierez1";
  constant Real F2=0.00785 "prierez2";
  constant Real F3=0.00785 "prierez3";
  Real h1(start=15, fixed=true) "vyska1";
  Real h2(start=15, fixed=true) "vyska2";
  Real h3(start=15, fixed=true) "vyska3";

equation
  if h1 < 29 then
	der(h1) = (q1-ro*g*h1/R1+ro*g*h2/R1)/F1;
	
	else if ((q1-ro*g*h1/R1+ro*g*h2/R1)/F1)<0 then
			der(h1) = (q1-ro*g*h1/R1+ro*g*h2/R1)/F1;
		 else der(h1)=0;
		 end if;
  end if;
	
  if h2 < 29 then
	der(h2) = (q2+ro*g*(h1-h2)/R1-ro*g*(h2-h3)/R2)/F2;
	
	else if ((q2+ro*g*(h1-h2)/R1-ro*g*(h2-h3)/R2)/F2)<0 then
			der(h2) = (q2+ro*g*(h1-h2)/R1-ro*g*(h2-h3)/R2)/F2;
		 else der(h2)=0;
		 end if;
  end if;
  
  if h3 < 29 then
	der(h3) = (q3+ro*g*(h2-h3)/R2-ro*g*h3/R3)/F3;
	
	else if ((q3+ro*g*(h2-h3)/R2-ro*g*h3/R3)/F3)<0 then
			der(h3) = (q3+ro*g*(h2-h3)/R2-ro*g*h3/R3)/F3;
		 else der(h3)=0;
		 end if;
  end if;

end Hydraulika;