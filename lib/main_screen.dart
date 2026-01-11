import 'package:flutter/material.dart';
import 'package:qwixa_app/dashboard/home/home.dart';

class MainScreen extends StatefulWidget {
  const MainScreen({super.key});

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _selectedIndex = 0;

  final List<Widget> _screens = [
    const HomePage(),
    const Center(child: Text('Pay Screen', style: TextStyle(fontSize: 24))),
    const Center(child: Text('Profile Screen', style: TextStyle(fontSize: 24))),
    const Center(
      child: Text('Notifications Screen', style: TextStyle(fontSize: 24)),
    ),
  ];

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'QwixaPay',
      theme: ThemeData(
        fontFamily: 'Manrope',
        primaryColor: const Color(0xFF25ac7f),
        scaffoldBackgroundColor: const Color(0xFFf6f8f7),
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xFF25ac7f),
          primary: const Color(0xFF25ac7f),
          surface: const Color(0xFFf6f8f7),
        ),
        useMaterial3: true,
        navigationBarTheme: const NavigationBarThemeData(
          backgroundColor: Color(0xFFf6f8f7),
          surfaceTintColor: Colors.transparent,
          indicatorColor: Colors.transparent,
        ),
      ),
      home: Scaffold(
        //backgroundColor: Theme.of(context).scaffoldBackgroundColor,
        body: _screens[_selectedIndex],
        bottomNavigationBar: Theme(
          data: Theme.of(context).copyWith(
            navigationBarTheme: const NavigationBarThemeData(
              backgroundColor: Color(0xFFf6f8f7),
              surfaceTintColor: Colors.transparent,
              indicatorColor: Colors.transparent,
            ),
          ),
          child: Container(
            decoration: BoxDecoration(
              color: const Color(0xFFf6f8f7),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withValues(alpha: 0.05),
                  blurRadius: 8,
                  offset: const Offset(0, -2),
                ),
              ],
            ),
            child: SafeArea(
              child: NavigationBar(
                elevation: 0,
                //backgroundColor: Colors.transparent,
                onDestinationSelected: _onItemTapped,
                selectedIndex: _selectedIndex,
                destinations: const [
                  NavigationDestination(icon: Icon(Icons.home), label: 'Home'),
                  NavigationDestination(
                    icon: Icon(Icons.payment),
                    label: 'History',
                  ),
                  NavigationDestination(
                    icon: Icon(Icons.account_circle),
                    label: 'Rewards',
                  ),
                  NavigationDestination(
                    icon: Icon(Icons.notifications),
                    label: 'Account',
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}
