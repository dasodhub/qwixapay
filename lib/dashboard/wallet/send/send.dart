import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class SendMoneyscreen extends StatelessWidget {
  const SendMoneyscreen({super.key});

  @override
  Widget build(BuildContext context) {
    // ignore: unused_local_variable

    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      appBar: AppBar(
        title: Text(
          'Send Money',
          style: GoogleFonts.manrope(fontSize: 18, fontWeight: FontWeight.w600),
        ),
      ),
      body: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.all(16),
          child: Column(
            children: [
              //Row for to bank 
              //Row for send to qwixapay user
              
            ],
          ),
        ),
      ),
    );
  }
}
