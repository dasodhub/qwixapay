import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

Widget quickServicesWidget() {
  return Container(
    padding: EdgeInsets.all(16),

    decoration: BoxDecoration(
      color: Colors.white.withValues(alpha: 0.5),
      borderRadius: BorderRadius.all(Radius.circular(12)),
    ),
    child: Column(
      children: [
        //First Row
        Row(
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            //Column for airtime
            Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              mainAxisAlignment: MainAxisAlignment.center,
              spacing: 4,
              children: [
                //Icon for airtime
                Image.asset('assets/icons/phone (2).png', height: 20),
                //Text
                Text(
                  'Airtime',
                  style: GoogleFonts.manrope(
                    fontSize: 12,
                    fontWeight: FontWeight.w500,
                    color: Colors.black,
                  ),
                ),
              ],
            ),
            //Column for data
            Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              mainAxisAlignment: MainAxisAlignment.center,
              spacing: 4,
              children: [
                //Icon for data
                Image.asset('assets/icons/wifi (2).png', height: 20),
                //Text
                Text(
                  'Data',
                  style: GoogleFonts.manrope(
                    fontSize: 12,
                    fontWeight: FontWeight.w500,
                    color: Colors.black,
                  ),
                ),
              ],
            ),
            //Column for betting
            Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              mainAxisAlignment: MainAxisAlignment.center,
              spacing: 4,
              children: [
                //Icon for betting
                Image.asset('assets/icons/football.png', height: 20),
                //Text
                Text(
                  'Betting',
                  style: GoogleFonts.manrope(
                    fontSize: 12,
                    fontWeight: FontWeight.w500,
                    color: Colors.black,
                  ),
                ),
              ],
            ),

            //Column for Electricity
            Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              mainAxisAlignment: MainAxisAlignment.center,
              spacing: 4,
              children: [
                //Icon for TV
                Image.asset('assets/icons/app.png', height: 20),
                //Text
                Text(
                  'More',
                  style: GoogleFonts.manrope(
                    fontSize: 13,
                    fontWeight: FontWeight.w500,
                    color: Colors.black,
                  ),
                ),
              ],
            ),
          ],
        ),

        //SizedBox(height: 16),

        //Second Row
        // Row(
        //   crossAxisAlignment: CrossAxisAlignment.center,
        //   mainAxisAlignment: MainAxisAlignment.spaceBetween,
        //   children: [
        //     //Coulum for TV Subscription
        //     Column(
        //       crossAxisAlignment: CrossAxisAlignment.center,
        //       mainAxisAlignment: MainAxisAlignment.center,
        //       spacing: 4,
        //       children: [
        //         //Icon for TV
        //         Image.asset('assets/icons/tv.png', height: 20),
        //         //Text
        //         Text(
        //           'TV',
        //           style: GoogleFonts.manrope(
        //             fontSize: 13,
        //             fontWeight: FontWeight.w500,
        //             color: Colors.black,
        //           ),
        //         ),
        //       ],
        //     ),

        //     //Column for refer and earn
        //     Column(
        //       crossAxisAlignment: CrossAxisAlignment.center,
        //       mainAxisAlignment: MainAxisAlignment.center,
        //       spacing: 4,
        //       children: [
        //         //Icon for TV
        //         Image.asset(
        //           'assets/icons/money-bag.png',
        //           height: 20,
        //         ),
        //         //Text
        //         Text(
        //           'Refer & Earn',
        //           style: GoogleFonts.manrope(
        //             fontSize: 13,
        //             fontWeight: FontWeight.w500,
        //             color: Colors.black,
        //           ),
        //         ),
        //       ],
        //     ),

        //     //Column for offers

        //     //Column for more

        //   ],
        // ),
      ],
    ),
  );
}
