import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:qwixa_app/dashboard/wallet/deposit/deposit.dart';
import 'package:qwixa_app/dashboard/wallet/send/send.dart';

Widget walletCardButtonsWidget(BuildContext context) {
  return Row(
    spacing: 16,
    children: [
      GestureDetector(
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => DepositScreen()),
          );
        },
        child: Container(
          padding: EdgeInsets.all(12),
          width: 150,
          height: 45,
          decoration: BoxDecoration(
            color: Color(0xFF25ac7f),
            borderRadius: BorderRadius.all(Radius.circular(12)),
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            spacing: 6,
            children: [
              //Icon for deposit
              SvgPicture.asset(
                'assets/icons/arrow-down-to-square.svg',
                height: 20,
                colorFilter: ColorFilter.mode(Colors.white, BlendMode.srcIn),
              ),
              //Text for deposit
              Text(
                'Deposit',
                style: GoogleFonts.manrope(
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                  color: Colors.white,
                ),
              ),
            ],
          ),
        ),
      ),
      // Send Money button
      GestureDetector(
        onTap: () {
          Navigator.push(
            context,
            MaterialPageRoute(builder: (context) => SendMoneyscreen()),
          );
        },
        child: Container(
          padding: EdgeInsets.all(12),
          width: 150,
          height: 45,
          decoration: BoxDecoration(
            color: Color(0xFF2f2637),
            borderRadius: BorderRadius.all(Radius.circular(12)),
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            spacing: 6,
            children: [
              //Icon for send money
              SvgPicture.asset(
                'assets/icons/paper-plane-top (2).svg',
                height: 16,
                colorFilter: ColorFilter.mode(Colors.white, BlendMode.srcIn),
              ),
              //Text for send money
              Text(
                'Send Money',
                style: GoogleFonts.manrope(
                  fontSize: 12,
                  fontWeight: FontWeight.w600,
                  color: Colors.white,
                ),
              ),
            ],
          ),
        ),
      ),
    ],
  );
}
