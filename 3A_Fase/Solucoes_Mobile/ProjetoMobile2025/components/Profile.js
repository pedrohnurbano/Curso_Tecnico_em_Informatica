import {View, Text, StyleSheet, Button, Image} from 'react-native';

export default function Profile() {
    return (
        <View style={styles.containerProfile} >
            <Text>Torre Eiffel</Text>
            <Text>- Ponto turístico.</Text>
            <Button>Visitar</Button>

            {/* Importação de imagem baixada: */}
            <Image style={{width:200,heigh:200}} source={require('../assets/torre.png')}/> 

            {/* Importação de imagem da web: */}
            <Image style={{width:200, height:200}} source={{uri: "https://cdn-imgix.headout.com/media/images/33ac22c30b1018ac1aa75c6a4c24075a-7504-Paris-ArcdeTriompheTicketswithRooftopAccess-09.jpg?auto=format&w=780&h=384&q=90&fit=crop&ar=16%3A10"}}/>

            {/* Adicional: <Image style={{width:200,heigh:200}} source={require('../assets/arco.png')}/> */}
        </View>
    );
}

export function Gallery(){
    return(
        <View style={styles.containerGallery} >
            <Text>Divisão 2/3</Text>
        </View>
    )
}

export function Artist(){
    return(
        <View style={styles.containerArtist} >
            <Text>Divisão 3/3</Text>
        </View>
    )
}

const styles = StyleSheet.create({
    containerProfile:{
        flex: 1,
        backgroundColor: '#009',
        alignItems: 'center',
        justifyContent: 'center',
    },
    containerGallery:{
        flex: 2,
        backgroundColor: '#fff',
        alignItems: 'center',
        justifyContent: 'center',
    },
    containerArtist:{
        flex: 3,
        backgroundColor: '#ff0000',
        alignItems: 'center',
        justifyContent: 'center',
    }
})