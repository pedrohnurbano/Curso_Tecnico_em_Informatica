import { View, StyleSheet, Button, TextInput, Text} from 'react-native';
import { useState } from "react";
import { collection, addDoc } from 'firebase/firestore';
import { db } from "../controller";
 
export default function CadProducts(){
 
    const [nome  , setNome] = useState("")
    const [preco , setPreco] = useState("")
    const [imagem, setImagem] = useState("") 
   
    const Register_Products = async () => {
        try {
            await addDoc(collection(db, "produtos"), {
                nome: nome,
                preco: parseFloat(preco),
                imagem: imagem,
            });
            setNome();
            setPreco();
            setImagem();
            console.log("Produto cadastrado com sucesso!");
        }
        catch (error) {
            console.log("Erro ao cadastrar produto!", error.message);
        }
    }

    return(
 
        <View style={styles.container}>
            <Text> Nome do Produto: </Text>
            <TextInput style={styles.txtinput}
                placeholder="Digite o nome do produto"
                placeholderTextColor={'black'}
                value={nome}
                onChangeText={setNome}
            />
            <Text> Preço do Produto: </Text>
            <TextInput style={styles.txtinput}
                placeholder="Digite o preço do produto"
                placeholderTextColor={'black'}
                value={preco}
                onChangeText={setPreco}
            />
            <Text> Imagem do Produto: </Text>
            <TextInput style={styles.txtinput}
                placeholder="Digite a imagem do produto"
                placeholderTextColor={'black'}
                value={imagem}
                onChangeText={setImagem}
            />
            
            <Button
                title="Cadastrar Produto" 
                color={'green'}
                onPress={Register_Products}
            />
       
        </View>
    )
}
 
const styles = StyleSheet.create({
    container:{
        backgroundColor: '#ffffff',
        flex: 1,
        padding: 20,
        paddingTop: 0,
        justifyContent: 'space-evenly',
    },
    txtinput: {
        height: 40,          
        margin: 12,          
        borderWidth: 1,      
        borderColor: 'black',  
        padding: 10,         
    },
})