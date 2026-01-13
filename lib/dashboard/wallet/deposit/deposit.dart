import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:qwixa_app/dashboard/wallet/deposit/widgets/deposit_details.dart';

class DepositScreen extends StatefulWidget {
  const DepositScreen({super.key});

  @override
  State<DepositScreen> createState() => _DepositScreenState();
}

class _DepositScreenState extends State<DepositScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      appBar: AppBar(
        title: Text(
          'Deposit Funds',
          style: GoogleFonts.manrope(fontSize: 18, fontWeight: FontWeight.w600),
        ),
      ),

      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              depositDetailsWidget(context)
            ],
          ),
        ),
      ),
    );
  }
}
