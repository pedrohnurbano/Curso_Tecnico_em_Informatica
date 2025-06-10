// import Profile from "./components/profile";
// import {Gallery, Artist} from "./components/profile";
// import Test from "./components/test";

import Login from "./screens/login";
import Home from "./screens/home";

import 'react-native-gesture-handler';
import { NavigationContainer } from "@react-navigation/native";
import { createDrawerNavigator } from "@react-navigation/drawer";

const Drawer = createDrawerNavigator();

export default function Drawer() {
  return (
    <NavigationContainer>
      <Drawer.Navigator>
        <Drawer.Screen name='Login' component={Login} />
        <Drawer.Screen name='Home' component={Home} />
      </Drawer.Navigator>
    </NavigationContainer>
  );
};