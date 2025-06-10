import {ImageBackground, View, Text, StyleSheet, Image, ScrollView} from 'react-native';

export default function Home() {
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
            <Text style={styles.txt}> Há mais de 65 anos, transformando pessoas e organizações por meio da educação e tecnologias inovadoras, contribuindo para um crescimento sustentável. </Text>
            <br></br>

            <View style={styles.row}>
                <Image style={styles.img} source={require('../assets/imagem_4.png')}/>
                <Text style={styles.txt2}> Com o objetivo de ser referência de educação e tecnologia de Santa Catarina, promovemos soluções inovadoras e na contribuição com o desenvolvimento sustentável. </Text>
            </View>
            <br></br>

            <View style={styles.row}>
                <Text style={styles.txt2}> Queremos realizar seus sonhos através da transformação técnica-profissional e sócio-emocional. </Text>
                <Image style={styles.img} source={require('../assets/imagem_3.png')}/> 
            </View>
            <br></br>

            <View style={styles.row}>
                <Image style={styles.img} source={{uri:"https://media.licdn.com/dms/image/v2/D4D0BAQFNJxvGYa4Nsg/company-logo_200_200/B4DZT18lNvHkAM-/0/1739293087184/satceducacao_logo?e=2147483647&v=beta&t=p7IcBHinGZsgVj8JlLn0uw5ud9O64KvsNZVLPJm_J-I"}}/> 
                <Image style={styles.img} source={require('../assets/imagem_2.png')}/> 
            </View>
            
            <br></br>
            <Text style={styles.txtcred}> Colégio SATC - Inovação, Tecnologia e Negócios. </Text>
            
        </ImageBackground>
        </View>
        </ScrollView>
    );
}

const styles = StyleSheet.create({
    container: {
        backgroundColor: '#ffffff',
        flex: 1,
        padding: 20,
        paddingTop: 0,
        justifyContent: 'space-evenly',
    },
    img: {
        width: 175,  /* Largura */
        height: 150, /* Altura */
        borderRadius: 5,
    },
    img2: {
        width: 380,  /* Largura */
        height: 150, /* Altura */
        borderRadius: 5,
    },
    viewimg: {
        alignItems: 'flex-end',

    },
    txt:{
        fontSize: 15,
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
    row:{
        flexDirection: 'row',
        justifyContent: 'space-evenly',
    },
    txtcred:{
        alignSelf: 'center',
    },
    image_back: {
        flex: 1,
        justifyContent: 'center',
      },
})