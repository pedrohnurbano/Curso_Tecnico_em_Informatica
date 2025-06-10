// import Profile from "./components/profile";
// import {Gallery, Artist} from "./components/profile";
// import Test from "./components/test";

import Login from "./screens/login";
import Home from "./screens/home";
import Feed from "./screens/feed"; // New page (feed)

import 'react-native-gesture-handler';
import { NavigationContainer } from "@react-navigation/native";
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";

const BottomTab = createBottomTabNavigator();

import Octicons from '@expo/vector-icons/Octicons';

export default function BottomTab() {
  return (
    <NavigationContainer>
      <BottomTab.Navigator initialRouteName="Login"
        screenOptions={{
          headerStyle: { backgroundColor: "green" }, // Cor de fundo do cabeçalho
          // headerTintColor: "white", // Cor do texto
          // tabBarActiveTintColor: "black",  // Cor do texto quando ativo **
          // tabBarInactiveTintColor: "black", // Cor do texto quando inativo **       
        }}>
        <BottomTab.Screen name='Login' component={Login}
        options={{
          tabBarActiveTintColor: "black",  // Cor do texto quando ativo
          tabBarInactiveTintColor: "black", // Cor do texto quando inativo
          tabBarStyle: { backgroundColor: "green" }, // Cor de fundo da barra

          tabBarIcon: () =>
          <Octicons name="person" size={24} color="black" />
        }}
        />
        <BottomTab.Screen name='Home' component={Home}
        options={{
          tabBarActiveTintColor: "black",  // Cor do texto quando ativo
          tabBarInactiveTintColor: "black", // Cor do texto quando inativo
          tabBarStyle: { backgroundColor: "green" }, // Cor de fundo da barra
          tabBarIcon: () =>
          <Octicons name="home" size={24} color="black" />
        }}
        />
        <BottomTab.Screen name='Feed' component={Feed}
        options={{
          tabBarActiveTintColor: "black",  // Cor do texto quando ativo
          tabBarInactiveTintColor: "black", // Cor do texto quando inativo
          tabBarStyle: { backgroundColor: "green" }, // Cor de fundo da barra
          tabBarIcon: () =>
          <Octicons name="archive" size={24} color="black" />
        }}
        />
      </BottomTab.Navigator>
    </NavigationContainer>
  );
};