import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';
import 'package:google_fonts/google_fonts.dart';

Widget welcomeWidget() {
  return Column(
    crossAxisAlignment: CrossAxisAlignment.start,
    children: [
      Row(
        crossAxisAlignment: CrossAxisAlignment.center,
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Image.asset('assets/images/logo.png', height: 50),
          SvgPicture.asset(
            'assets/icons/bell (5).svg',
            height: 20,
            colorFilter: ColorFilter.mode(Colors.grey, BlendMode.srcIn),
          ),
        ],
      ),

      SizedBox(height: 16),

      //Welcome section
      Text('Welcome, Oshoke', style: GoogleFonts.manrope(fontSize: 18)),
    ],
  );
}