import { StyleSheet, View, Text, Image, } from "react-native"

export default function CardProduct({id, nome, preco, imagem}){
    return(
        <View style={styles.card}>
            <Image source={{uri: imagem}} style={styles.img}/>
            <Text> ID: {id} </Text>
            <Text> Nome: {nome} - Preço: R$ {preco.toFixed(2)}</Text>
        </View>
    )
}

const styles = StyleSheet.create({
    card:{
        marginBottom   : 10      ,
        padding        : 10      ,
        backgroundColor: '#fff'  ,
        borderRadius   : 5       ,
        alignItems     : 'center',
    },
    img:{
        width : 100,
        height: 100,
    },
});