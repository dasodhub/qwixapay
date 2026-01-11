import 'package:carousel_slider/carousel_slider.dart';
import 'package:flutter/material.dart';

Widget adsWidget() {
  return CarouselSlider(
    items: [
      //1st Image of Slider
      Container(
        margin: EdgeInsets.all(6),
        width: double.infinity,
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(8),
          image: DecorationImage(
            image: AssetImage(
              'assets/images/Qwixa website banner 1_012641.png',
            ),
            fit: BoxFit.cover,
          ),
        ),
      ),

      //2nd Image of Slider
      Container(
        margin: EdgeInsets.all(6),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(8),
          image: DecorationImage(
            image: AssetImage(
              'assets/images/Qwixa website banner 2_012640.png',
            ),
            fit: BoxFit.cover,
          ),
        ),
      ),

      //3rd Image of Slider
      Container(
        margin: EdgeInsets.all(6),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(8),
          image: DecorationImage(
            image: AssetImage(
              'assets/images/Qwixa website banner 3_012706.png',
            ),
            fit: BoxFit.cover,
          ),
        ),
      ),
    ],
    options: CarouselOptions(
      height: 150,
      autoPlay: true,
      enlargeCenterPage: true,
      aspectRatio: 16 / 9,
      autoPlayCurve: Curves.fastOutSlowIn,
      enableInfiniteScroll: true,
      autoPlayAnimationDuration: Duration(milliseconds: 800),
      viewportFraction: 0.8,
    ),
  );
}
