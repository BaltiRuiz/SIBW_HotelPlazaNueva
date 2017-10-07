function rotar(){ 
    var position = 0 ;
    var mode = 0 ;
	var timer = setInterval(sliderScroll, 25) ;   // La función sliderScroll se repetirá indefinidamente cada 50 msegundos

    function sliderScroll(){   
        position = document.getElementById("slider").scrollLeft ;   // Calcula la posición actual del contenedor

        if (mode == 0)
            position++ ;
        else
            position-- ;

        if (position == 500)  // final
            mode = 1 ;
        else if (position == 0)
            mode = 0 ;

        slider.scrollLeft = position ;
    }
}