import {ImageBackground, View, Text, StyleSheet, Image, Button, ScrollView} from 'react-native';

export default function Feed() {
    return (
        <ScrollView>
        <View style={styles.container}>
        <ImageBackground  source={require('../assets/diamantes_background.png')} resizeMode="cover" style={styles.image_back}>

            <Image source={require('../assets/favicon.png')}/> 
            <Text style={styles.text_cab}> COLÉGIO SATC </Text>

            <View style={styles.viewimg}>
                <Image style={styles.img2} source={require('../assets/imagem_1.png')}/> 
            </View>

            <br></br>
            <Text style={styles.txt}> Feed do Colégio SATC </Text>
            <br></br>

            <View>
                <Text style={styles.txt2}> Com o objetivo de ser referência de educação e tecnologia de Santa Catarina, promovemos soluções inovadoras e na contribuição com o desenvolvimento sustentável. </Text>
                <br></br>
                <Image style={styles.img} source={require('../assets/imagem_4.png')}/>
                <br></br>    
                <Text style={styles.txt2}> Com o objetivo de ser referência de educação e tecnologia de Santa Catarina, promovemos soluções inovadoras e na contribuição com o desenvolvimento sustentável. </Text>
                <br></br>
                <Image style={styles.img} source={require('../assets/imagem_4.png')}/>
                <br></br>
                <Text style={styles.txt2}> Com o objetivo de ser referência de educação e tecnologia de Santa Catarina, promovemos soluções inovadoras e na contribuição com o desenvolvimento sustentável. </Text>
                <br></br>
                <Image style={styles.img} source={require('../assets/imagem_4.png')}/>
                <br></br>
            </View>

            <Button
                title="Saiba Mais" 
                color={'green'}
                onPress={ () => navigation.navigate('Home')}
            />
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
    img:{
        width: 175,  /* Largura */
        height: 150, /* Altura */
        borderRadius: 5,
        alignSelf: 'center',
    },
    viewimg:{
        alignItems: 'flex-end',

    },
    txt:{
        fontSize: 20,
        color: 'green',
        textAlign: 'center',
        width: 380,
        fontWeight: 'bold',
    },
    txt2:{
        fontSize: 15,
        alignSelf: 'center',
        textAlign: 'center',
        width: 350,
    },
    txtcred:{
        alignSelf: 'center',
    },
    image_back: {
        flex: 1,
        justifyContent: 'center',
      },
})