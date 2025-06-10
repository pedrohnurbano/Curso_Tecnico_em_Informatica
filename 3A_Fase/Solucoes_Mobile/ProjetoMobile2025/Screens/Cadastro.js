import {ImageBackground, View, Text, StyleSheet, Image, TextInput, Button, ScrollView} from 'react-native';
import Octicons from '@expo/vector-icons/Octicons';
import { useState } from 'react';
import { createUserWithEmailAndPassword } from "firebase/auth";
import { auth } from "../controller";

export default function Cadastro({navigation}) {
    const [email, setEmail] = useState("");
    const [senha, setSenha] = useState("");

    const Cadastro_Usuario = () => {
        createUserWithEmailAndPassword(auth, email, senha)
        .then((userCredential) => {
            console.log("Usuário cadastrado!", userCredential.user.email);
            navigation.navigate('Tela - Login');
        })
        .catch((error) => {
            console.error("Erro ao cadastrar o usuário!", error.message);
        });
    }

    return (
        <ScrollView>
        <View style={styles.container}>
        <ImageBackground  source={require('../assets/diamantes_background.png')} resizeMode="cover" style={styles.image_back}>

            <Image source={require('../assets/favicon.png')}/>
            <Text style={styles.text_cab}> COLÉGIO SATC </Text>
            <View styles={styles.text_encima}>
                <View style={styles.viewimg}>
                <Image style={styles.img2} source={require('../assets/imagem_1.png')}/> 
                </View>
                <br></br>
                <Text style={styles.txt}> Menu de Cadastro: </Text>
                <br></br>

                <Text> E-mail: </Text>
                <TextInput style={styles.txtinput}
                    placeholder="Digite seu e-mail"
                    placeholderTextColor={'black'}
                    value={email}
                    onChangeText={setEmail}
                    />
                <Text> Senha: </Text>
                <TextInput style={styles.txtinput}
                    placeholder="Digite sua senha"
                    placeholderTextColor={'black'}
                    value={senha}
                    onChangeText={setSenha}
                    secureTextEntry={true}
                />
                <br></br>
                <Button
                    title="Cadastrar" 
                    color={'green'}
                    onPress={Cadastro_Usuario}
                />
                {/* <TouchableOpacity
                    style={styles.button}
                    onPress={() => navigation.navigate('Tela - Login')}
                >
                    <Text style={styles.buttonText}>Voltar para Login</Text>
                </TouchableOpacity> */}
            </View>

            <br></br>
            <Text style={styles.txtcred}> Colégio SATC - Inovação, Tecnologia e Negócios. </Text>
        </ImageBackground>
        </View>
        </ScrollView>
    );
}

const styles = StyleSheet.create({
    container:{
        backgroundColor: '#ffffff',
        flex: 1,
        padding: 20,
        paddingTop: 0,
        justifyContent: 'space-evenly',
    },
    txt:{
        fontSize: 20,
        textAlign: 'center',
        width: 380,
        fontWeight: 'bold',
    },
    txt2:{
        fontSize: 15,
        alignSelf: 'center',
        textAlign: 'justify',
        width: 250,
    },
    txtcred:{
        alignSelf: 'center',
    },
    image_back: {
        flex: 1,
        justifyContent: 'center',
      },
    txtinput: {
        height: 40,          
        margin: 12,          
        borderWidth: 1,      
        borderColor: 'black',  
        padding: 10,         
    },
    text_encima: {
        
    }
})