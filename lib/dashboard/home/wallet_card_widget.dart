import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:qwixa_app/dashboard/home/wallet_card_buttons.dart';

Widget walletCardWidget(BuildContext context) {
  return Column(
    crossAxisAlignment: CrossAxisAlignment.start,
    children: [
      Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            crossAxisAlignment: CrossAxisAlignment.center,
            spacing: 6,
            children: [
              Text(
                'Account balance',
                style: GoogleFonts.manrope(fontSize: 13, color: Colors.grey),
              ),
              // Eye toggle icon
              SvgPicture.asset(
                'assets/icons/eye (1).svg',
                height: 16,
                colorFilter: ColorFilter.mode(Colors.grey, BlendMode.srcIn),
              ),
            ],
          ),
          Text(
            '₦0.00',
            style: GoogleFonts.manrope(
              fontSize: 32,
              fontWeight: FontWeight.w600,
            ),
          ),
          SizedBox(height: 6),
          //Add and transfer
          walletCardButtonsWidget(context),
        ],
      ),
    ],
  );
}
