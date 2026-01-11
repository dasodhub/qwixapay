import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';
import 'package:google_fonts/google_fonts.dart';

Widget depositDetailsWidget(BuildContext context) {
  return Column(
    children: [
      Container(
        padding: EdgeInsets.all(16),
        width: double.infinity,
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.all(Radius.circular(12)),
          border: Border.all(color: Color(0xFFe5e5e5), width: 1),
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          mainAxisAlignment: MainAxisAlignment.start,
          spacing: 16,
          children: [
            //Row for Bank Name
            Row(
              spacing: 16,
              children: [
                //Container with Icon
                Container(
                  padding: EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: Colors.grey.withOpacity(0.2),
                    borderRadius: BorderRadius.all(Radius.circular(3)),
                  ),
                  child: SvgPicture.asset(
                    'assets/icons/bank (1).svg',
                    height: 24,
                    colorFilter: ColorFilter.mode(Colors.grey, BlendMode.srcIn),
                  ),
                ),
                //Column for bank details
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisAlignment: MainAxisAlignment.start,
                  children: [
                    Text(
                      'Bank Name',
                      style: GoogleFonts.manrope(
                        fontSize: 12,
                        fontWeight: FontWeight.w400,
                        color: Color(0xFF2f2637),
                      ),
                    ),
                    Text(
                      'Nombank MFB',
                      style: GoogleFonts.manrope(
                        fontSize: 16,
                        fontWeight: FontWeight.w600,
                        color: Color(0xFF000000),
                      ),
                    ),
                  ],
                ),
              ],
            ),

            //Row for Account Holder
            Row(
              spacing: 16,
              children: [
                //Container with Icon
                Container(
                  padding: EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: Colors.grey.withOpacity(0.2),
                    borderRadius: BorderRadius.all(Radius.circular(3)),
                  ),
                  child: SvgPicture.asset(
                    'assets/icons/user (2).svg',
                    height: 24,
                    colorFilter: ColorFilter.mode(Colors.grey, BlendMode.srcIn),
                  ),
                ),
                //Column for bank details
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisAlignment: MainAxisAlignment.start,
                  children: [
                    Text(
                      'Account Holder Name',
                      style: GoogleFonts.manrope(
                        fontSize: 12,
                        fontWeight: FontWeight.w400,
                        color: Color(0xFF2f2637),
                      ),
                    ),
                    Text(
                      'Qwixa/John Oshoke',
                      style: GoogleFonts.manrope(
                        fontSize: 16,
                        fontWeight: FontWeight.w600,
                        color: Color(0xFF000000),
                      ),
                    ),
                  ],
                ),
              ],
            ),

            //Row for account Number
            Row(
              spacing: 16,
              children: [
                //Container with Icon
                Container(
                  padding: EdgeInsets.all(8),
                  decoration: BoxDecoration(
                    color: Colors.grey.withOpacity(0.2),
                    borderRadius: BorderRadius.all(Radius.circular(3)),
                  ),
                  child: SvgPicture.asset(
                    'assets/icons/pin_24dp_E3E3E3_FILL0_wght400_GRAD0_opsz24.svg',
                    height: 24,
                    // colorFilter: ColorFilter.mode(
                    //   Colors.grey,
                    //   BlendMode.srcIn,
                    // ),
                  ),
                ),
                //Column for bank details
                Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisAlignment: MainAxisAlignment.start,
                  children: [
                    Text(
                      'Account Number',
                      style: GoogleFonts.manrope(
                        fontSize: 12,
                        fontWeight: FontWeight.w400,
                        color: Color(0xFF2f2637),
                      ),
                    ),
                    Text(
                      '1575575829',
                      style: GoogleFonts.manrope(
                        fontSize: 16,
                        fontWeight: FontWeight.w600,
                        color: Color(0xFF000000),
                      ),
                    ),
                  ],
                ),

                Spacer(),

                //Container for copy Icon
                Container(
                  padding: EdgeInsets.only(
                    top: 8,
                    bottom: 8,
                    left: 12,
                    right: 12,
                  ),
                  decoration: BoxDecoration(
                    color: Theme.of(context).primaryColor.withOpacity(0.2),
                    borderRadius: BorderRadius.all(Radius.circular(6)),
                  ),
                  child: Row(
                    spacing: 8,
                    children: [
                      SvgPicture.asset(
                        'assets/icons/copy.svg',
                        height: 16,
                        colorFilter: ColorFilter.mode(
                          Theme.of(context).primaryColor,
                          BlendMode.srcIn,
                        ),
                      ),
                      Text(
                        'Copy',
                        style: GoogleFonts.manrope(
                          fontSize: 12,
                          fontWeight: FontWeight.w400,
                          color: Theme.of(context).primaryColor,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ],
        ),
      ),

      SizedBox(height: 16),

      //Text
      Text(
        'Use these details to deposit funds to your account.\nDeposits may take 0-2min to reflect.',
        style: GoogleFonts.manrope(
          fontSize: 13,
          fontWeight: FontWeight.w400,
          color: Color(0xFF2f2637),
        ),
        textAlign: TextAlign.center,
      ),
    ],
  );
}
