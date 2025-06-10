// import Profile from "./components/profile";
// import {Gallery, Artist} from "./components/profile";
// import Test from "./components/test";

import Login from "./screens/login";
import Home from "./screens/home";

import 'react-native-gesture-handler';

import { NavigationContainer } from "@react-navigation/native";
import { createStackNavigator } from "@react-navigation/stack";

const Stack = createStackNavigator();

export default function Stack() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName='Login'>
        <Stack.Screen name='Home' component={Home}/>
        <Stack.Screen name='Login' component={Login}/>
      </Stack.Navigator>
    </NavigationContainer>
  );
};