import {View, Text, Button, StyleSheet, TouchableOpacity} from 'react-native';
import { useState } from 'react';

export default function Count() {

    const [contador, setContador] = useState(2); // Valor inicial é 2;

function Aumentar() {
    setContador(contador + 1)
}

function Diminuir() {
    if (contador > 0) {
        setContador(contador - 1)
    }
}

    return(
        <View style={styles.container}>
            <Text style={styles.title}> Meu contador </Text>
            <Text style={styles.txt}> {contador} </Text>
            
            <View style={styles.row}>
                <Button 
                    title='+'
                    color={'green'}
                    onPress={Aumentar}
                />
                <Button 
                    title='-'
                    color={'green'}
                    onPress={Diminuir}
                />
            </View>

            <br></br>

            <View style={styles.row}>
                <TouchableOpacity
                    style={styles.button}
                    onPress={Aumentar}>
                +
                </TouchableOpacity>

                <TouchableOpacity
                    style={styles.button}
                    onPress={Diminuir}>
                -
                </TouchableOpacity>
            </View>
        </View>
    )
}

const styles = StyleSheet.create({
        container:{
            flex: 1,
            alignItems: 'center',
            justifyContent: 'center'
        },
        title:{
            fontSize: 40,
            color: 'green',
        },
        txt:{
            fontSize: 15,
            color: 'black',
        },
        row:{
            flexDirection: 'row',
            justifyContent: 'space-evenly',
            width: 400,
        },
        button:{
            width: '40%',
            color: 'white',
            backgroundColor: 'green',
            borderRadius: 5,
            alignItems: 'center'
        }
    }
)