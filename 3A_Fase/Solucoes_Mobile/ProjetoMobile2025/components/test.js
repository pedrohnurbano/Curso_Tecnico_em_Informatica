import {View, Text, StyleSheet, Image, Button, TextInput} from 'react-native';

export default function Test() {
    return (
        <View style={styles.container}>

            <Text> VERSACE'S SHOES SHOP </Text>

            <View style={styles.viewimg}>
                <Image style={styles.img} source={require('../assets/versace.png')}/> 
            </View>

            <Text style={styles.txt}> Versace, sinta o luxo de utilizar a marca mais luxuosa do mundo em seus pés. </Text>
            
            <View style={styles.row}>
                <Image style={styles.img} source={{uri:"https://debbydotattractions.com/wp-content/uploads/2022/08/WhatsApp-Image-2022-08-17-at-11.16.47-PM.jpeg"}}/> 
                <Image style={styles.img} source={require('../assets/torre.png')}/> 
            </View>
            
            <Text style={styles.txtcred}> Created by Pedro Nascimento, 2025 </Text>

            <Text> Nome: </Text>
            <TextInput style={styles.txtinput}
                placeholder="Digite seu nome"
                placeholderTextColor={'black'}
                />
            <Text> Mensagem: </Text>
            <TextInput style={styles.txtinput}
                placeholder="Digite a mensagem"
                placeholderTextColor={'black'}
            />

            <Button
                title="Enviar" 
                color={'black'} 
                //disable
            />
        </View>
    );
}

const styles = StyleSheet.create({
    container:{
        backgroundColor: '#ffffff',
        flex: 1,
        padding: 20,
        paddingTop: 50,
        justifyContent: 'space-evenly',
    },
    img:{
        width: 175,  /* Largura */
        height: 150, /* Altura */
        borderRadius: 5,
    },
    viewimg:{
        alignItems: 'flex-end',

    },
    txt:{
        fontSize: 15,
        alignSelf: 'flex-end',
        width: 250,
    },
    row:{
        flexDirection: 'row',
        justifyContent: 'space-evenly',
    },
    txtcred:{
        alignSelf: 'center',
    },


    txtinput: {
        height: 40,           /* Altura                    */
        margin: 12,           /* Margem                    */
        borderWidth: 1,       /* Largura da borda          */
        borderColor: 'black', /* Cor da borda              */
        //borderRadius: 5,    /* Arredondamento dos cantos */
        padding: 10,          /* . */
    },
})