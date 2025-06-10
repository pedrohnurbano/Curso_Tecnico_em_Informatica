// import Profile from "./components/profile";
// import {Gallery, Artist} from "./components/profile";
// import Test from "./components/test";

import Octicons from '@expo/vector-icons/Octicons';

import 'react-native-gesture-handler';
import { NavigationContainer      } from "@react-navigation/native"     ;
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";
import { createStackNavigator     } from "@react-navigation/stack"      ;

import Login            from "./Screens/Login"      ;
import Home             from "./Screens/Home"       ;
import Feed             from "./Screens/Feed"       ; 
import Count            from "./Screens/Count"      ;
import Product          from "./Screens/Product"    ;
import Cadastro         from "./Screens/Cadastro"   ;
import CadProducts      from "./Screens/CadProducts";

function BottomTab() {
  const Tab = createBottomTabNavigator();
  return (
    <Tab.Navigator>
      <Tab.Screen name='Home - Tab' component={Home}
        options={{
          tabBarActiveTintColor:          "black"  ,
          tabBarInactiveTintColor:        "black"  ,
          tabBarStyle: { backgroundColor: "green" },
          tabBarIcon: () =>
            <Octicons name="home" size={24} color="black" />
        }}
      />
      <Tab.Screen name='Feed - Tab' component={Feed}
        options={{
          tabBarActiveTintColor: "black", 
          tabBarInactiveTintColor: "black", 
          tabBarStyle: { backgroundColor: "green" }, 
          tabBarIcon: () =>
            <Octicons name="archive" size={24} color="black" />
        }}
      />
      <Tab.Screen name='Count - Tab' component={Count}
        options={{
          tabBarActiveTintColor: "black",  
          tabBarInactiveTintColor: "black", 
          tabBarStyle: { backgroundColor: "green" }, 
          tabBarIcon: () =>
            <Octicons name="plus-circle" size={24} color="black" />
        }}
      />
      <Tab.Screen name='Product - Tab' component={Product}
        options={{
          tabBarActiveTintColor: "black",  
          tabBarInactiveTintColor: "black", 
          tabBarStyle: { backgroundColor: "green" }, 
          tabBarIcon: () =>
            <Octicons name="beaker" size={24} color="black" />
        }}
      />
      <Tab.Screen name='CadProducts - Tab' component={CadProducts}
        options={{
          tabBarActiveTintColor: "black",  
          tabBarInactiveTintColor: "black", 
          tabBarStyle: { backgroundColor: "green" },
          tabBarIcon: () =>
            <Octicons name="checklist" size={24} color="black" />
        }}
      />
    </Tab.Navigator>
  )
}

export default function App() {
  const Stack = createStackNavigator();
  return (
    <NavigationContainer>
      <Stack.Navigator>
        <Stack.Screen name="Tela - Login" component={Login} />
        <Stack.Screen name="Tela - Cadastro" component={Cadastro} />
        <Stack.Screen options={{ headerShown: false }} name="Home" component={BottomTab} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}