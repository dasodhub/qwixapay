import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class AllServicesScreen extends StatelessWidget {
  const AllServicesScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      appBar: AppBar(
        title: Text(
          'All Services',
          style: GoogleFonts.manrope(fontSize: 18, fontWeight: FontWeight.w600),
        ),
      ),
    );
  }
}