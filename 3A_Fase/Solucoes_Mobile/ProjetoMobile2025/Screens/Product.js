import {View, Text, StyleSheet, FlatList, Image} from 'react-native';
import { useEffect, useState } from 'react';
import CardProduct from './CardProduct';
import { db } from "../controller";
import { collection, getDocs } from "firebase/firestore";

export default function Product() {

const [produtos, setProdutos] = useState([]);

useEffect(() => {
    async function Carregar_Produtos() {
        try{
            const querySnapshot = await getDocs(collection(db, 'produtos'));
            const lista = [];
            querySnapshot.forEach((doc) => {
                lista.push({id: doc.id, ...doc.data() }); 
            });
            setProdutos(lista);  
        } 
        catch(error) {
            console.log('Erro ao buscar o produto!', error);
        }
    }
    Carregar_Produtos();
}, []);

    return (
        <View style={styles.container}>
            <Text style={styles.txt}> Produtos </Text>
            <FlatList
                data={produtos}
                renderItem={({item}) => (
                    <CardProduct
                        nome = {item.nome}
                        preco = {item.preco}
                        imagem = {item.imagem}
                    />
                )}
                keyExtractor={item => item.id}
            />
            <Text style={styles.txtcred}> Colégio SATC - Inovação, Tecnologia e Negócios. </Text>
        </View>
    );
}

const styles = StyleSheet.create({
    container:{
        flex           : 1        ,
        alignItems     : 'center' ,
        justifyContent : 'center' ,
        backgroundColor: '#f5f5f5',
        padding        : 10       ,
    },
    txt:{
        fontSize    : 25     ,
        fontWeight  : 'bold' ,
        color       : 'green',
        marginBottom: 20     ,
    },
    txtcred:{
        alignSelf: 'center',
    },
});

// // {id: 0 , nome: 'iPhone 16 Pro Max'       , preco: 11999.00, imagem: 'https://m.media-amazon.com/images/I/61SndXmTWoL._AC_UF1000,1000_QL80_.jpg'                                                                   },            
// // {id: 1 , nome: 'Samsung Galaxy S23 Ultra', preco: 10499.00, imagem: 'https://samsungbrshop.vtexassets.com/arquivos/ids/220155/sm-s918_galaxys23ultra_front_phantomblack_221118.jpg?v=638309856309030000'          },
// // {id: 2 , nome: 'Xiaomi 13 Pro'           , preco: 8999.00, imagem: 'https://m.media-amazon.com/images/I/51G7tyeELvL.jpg'                                                                                          },
// // {id: 3 , nome: 'Motorola Edge 40 Pro'    , preco: 7999.00, imagem: 'https://http2.mlstatic.com/D_NQ_NP_617813-MLA74676698338_022024-F.jpg'                                                                        },
// // {id: 4 , nome: 'OnePlus 11 Pro'          , preco: 8499.00, imagem: 'https://http2.mlstatic.com/D_NQ_NP_746354-MLA54227037691_032023-F.jpg'                                                                        },
// // {id: 5 , nome: 'Google Pixel 8 Pro'      , preco: 9499.00, imagem: 'https://cdn.awsli.com.br/2500x2500/1271/1271561/produto/237703928/smartphone-google-pixel-8-pro-512gb-obsidian-black--1--i7br11nm5y.jpg'      },
// // {id: 6 , nome: 'Sony Xperia 1 V'         , preco: 10999.00, imagem: 'https://cdn.awsli.com.br/600x450/1271/1271561/produto/274135612/smartphone-sony-xperia-1-v-256gb--1--wd52o29hjw.jpg'                         },
// // {id: 7 , nome: 'Asus ROG Phone 7'        , preco: 6999.00, imagem: 'https://dlcdnwebimgs.asus.com/gain/169BAE2A-C0D8-4651-8FBD-D09396315571'                                                                      },
// // {id: 8 , nome: 'Nokia XR20'              , preco: 3999.00, imagem: 'https://m.media-amazon.com/images/I/71XsQJoq0XL.jpg'                                                                                          },
// // {id: 9 , nome: 'Oppo Find X6 Pro'        , preco: 8999.00, imagem: 'https://acdn-us.mitiendanube.com/stores/003/772/365/products/7d2db81edc38c95748813cf787d11c2e-b22eadc8e5df0e8cde17056810239487-1024-1024.jpg' },
// // {id: 10, nome: 'Vivo X90 Pro'            , preco: 8999.00, imagem: 'https://br.etoren.com/upload/images/0.92103100_1669956306_vivo-x90-pro-plus-5g-v2227a-dual-sim-512gb-black-12gb-ram.jpg'                      },