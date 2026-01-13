import 'package:flutter/material.dart';
import 'package:qwixa_app/dashboard/home/ads_widget.dart';
import 'package:qwixa_app/dashboard/home/quick_services.dart';
import 'package:qwixa_app/dashboard/home/recent_transaction_widgets.dart';
import 'package:qwixa_app/dashboard/home/wallet_card_widget.dart';
import 'package:qwixa_app/dashboard/home/welcome_widget.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Theme.of(context).scaffoldBackgroundColor,
      body: SafeArea(
        child: Padding(
          padding: EdgeInsets.all(16),
          child: SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                //QwixaLogo  and icon sections
                welcomeWidget(),
                SizedBox(height: 16),
                //Wallet Card
                walletCardWidget(context),
                SizedBox(height: 16),
                //Service card
                quickServicesWidget(context),
                SizedBox(height: 16),
                //Ads section
                adsWidget(),
                SizedBox(height: 16),
                //Transaction history
                recentTransactionWidget(),
                
              ],
            ),
          ),
        ),
      ),
    );
  }
}
