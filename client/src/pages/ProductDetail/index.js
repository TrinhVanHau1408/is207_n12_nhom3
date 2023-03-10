import React, { useState, useEffect } from 'react';
import classNames from 'classnames/bind';
import Styled from 'styled-components';
import { Link } from 'react-router-dom';
import { MinusOutlined, PlusOutlined } from '@ant-design/icons';
import 'antd/dist/antd.min.css';
import { Col, Row, Button, Image, Typography, Input, Descriptions, notification } from 'antd';
import { useParams } from 'react-router-dom';
import Comments from '~/components/Comment';
import { useNavigate } from 'react-router-dom';
import styles from './ProcductDetail.module.scss';
import { AuthContext } from '~/Context/AuthProvider';
import { AppContext } from '~/Context/AppProvider';
import formatVND from '~/utilis';
const cx = classNames.bind(styles);

const WarpperStyled = Styled.div`
    align-items: center;
    background: #E8EDED;
    width: 100%;

`;
const WarpperDetailStyled = Styled.div`
    align-items: center;
    background: #fff;
    margin: 0 100px;
`;
const DetailStyled = Styled.div`
    border-radius: 25px !important;
    // padding: 10px 10px;
    margin-top: 10px;
    .product {
        
        Col {
            height: 51px;
        }
        &__ten, &__tinhTrang, &__mau_tieuDe,&__gia, &__boNho, &__soLuong {
            margin-left: 10px;
        }

    
        &__soLuong Input {
            border: none;
            text-align: center;
            width: 20px;
        }
      

    }

    .error {
        background: #ffcdd2;
        color: #fff;
    }
    .errContent {
        text-align: center;
        padding-bottom: 5px;
      
    }
`;
const WarpperLinkStyled = Styled.div`
    padding: 20px 0;
    background: #E8EDED;
    
`;
const DescriptionsStyled = Styled(Descriptions)`
    width: 80%;
    min-height: 100px;
    border-radius: 5px;
    table{
       border: 1px solid #000;
    }
    .product__noiDungKhuyenMai {
       margin: 0;
       background: #DEDEDE;
       text-align: justify;
      
    }

    .product_thongSo, .product__noiDungThongSo{
        margin: 0;
        background: #DEDEDE;
       
    }

    .product_thongSo {
        text-align: center;
        // font-size: 18px;
        font-weight: bold;
    }

    .product__noiDungThongSo {
        text-align: justify;
    }

`;

const Img = Styled(Image)`
    max-width:400px ;
    max-height:500px; 
    width: auto;
    height: auto
`;

const ButtonStyled = Styled.div`
    display: flex;
    flex-direction: row;
    width: 100%;
    margin: 15px 0;
    color: #757575;
    font-size: .875rem;
    align-items: center;

    .color, .mau, .boNho {
        margin-right:5px;
    }

    .mau {
        width: 10px;
        height: auto;
        font-size: 10px;
    }
    .selected {
        background: #2a254b !important;
        color: #fff;
        border: none;
    }
`;

const WarpperButtonHandleStyled = Styled.div`
    margin: 20px 0;
    // display: flex;
    // justify-content: start;
   
    .btn_add {
        color: #2a254b;
        border: 1px solid #2a254b;
    }
    .btn_add:hover {
        transform: scale(1.1);
        opacity: 0.8;
    }
    .btn_buy {
        margin-left: 50px;
        background: rgb(238, 77, 45);
        color: #fff;
        border: 1px solid #2a254b;

    }
    .btn_buy:hover {
        transform: scale(1.1);
        opacity: 0.8;
    }

`;
const WarpperThongSoStyled = Styled.div`
    margin-top: 20px;
    display: flex;
    justify-content: end;
`;
function unique(variants) {
    let phoneColor = [
        {
            id: variants[0].colorId,
            name: variants[0].color,
        },
    ];

    variants.forEach((vari) => {
        let colorId = phoneColor.map((phoneC) => phoneC.id);
        if (!colorId.includes(vari.colorId)) {
            phoneColor.push({
                id: vari.colorId,
                name: vari.color,
            });
        }
    });
    return phoneColor;
}
function ProcductDetail(props) {
    const [api, contextHolder] = notification.useNotification();
    const { user } = React.useContext(AuthContext);
    const { setCartChange, setSelectedCartId } = React.useContext(AppContext);

    const [detail, setDetail] = useState([]);
    const [price, setPrice] = useState(0);
    const [colors, setColors] = useState([]);
    const [boNhos, setBoNhos] = useState([]);
    const [quantitySelect, setQuantitySelect] = useState(1);
    const [loaded, setLoaded] = useState(false);
    const [selectedColor, setSelectedColor] = useState(0);
    const [selectedRam, setSelectedRam] = useState(0);
    const [selectedRom, setSelectedRom] = useState(0);
    const [variant, setVariant] = useState({});
    const [quantity, setQuantity] = useState();
    const [isError, setIsError] = useState(false);

    const params = useParams();
    const slug = params.slug;

    const navigate = useNavigate();
    // Call API Phone :slug
    useEffect(() => {
        fetch('/api/phone/' + slug)
            .then((data) => data.json())
            .then((res) => {
                setDetail(res);
                setPrice(parseFloat(res.phone.priceSale));
                setLoaded(true);
            })
            .catch((err) => console.log(err));
    }, [slug]);

    function updateQuanity(variant) {
        const sumQuantity = variant.reduce((total, variCurr) => {
            return total + variCurr.quantity;
        }, 0);
        setQuantity(sumQuantity);
    }
    // useEffect(() => {

    //     // T??nh t???ng t???n kho hi???n c?? c???a t???t c??? bi???n th???
    //     if (loaded) {
    //         updateQuanity(detail.variants);
    //     }
    // }, [detail, selectedColor])

    useEffect(() => {
        if (loaded) {
            setSelectedRam(0);
            setSelectedRom(0);
            // setSelectedColor(0);
            updateQuanity(detail.variants);
        }
    }, [detail, selectedColor]);

    useEffect(() => {
        // L???y m??u c???a s???n ph???m kh??ng tr??ng l???p
        if (detail.variants) setColors(unique(detail.variants));
    }, [slug, detail]);

    // X??? l?? t??ng s??? l?????ng ?????t
    const handleIncrease = () => {
        if (quantitySelect < quantity) {
            setQuantitySelect(quantitySelect + 1);
        }
    };

    // X??? l?? gi???m s??? l?????ng ?????t
    const handleDecrease = () => {
        if (quantitySelect > 1) {
            setQuantitySelect(quantitySelect - 1);
        }
    };

    // X??? ??
    const handleInputChangeQuanity = (e) => {
        const inputQuanity = e.target.value;

        if (!Number.isNaN(inputQuanity) || inputQuanity == '') {
            console.log(inputQuanity);
            if (inputQuanity === '') {
                setQuantitySelect('');
                return;
            }
            if (quantitySelect < parseInt(inputQuanity)) {
                setQuantitySelect(quantitySelect);
                return;
            }

            if (parseInt(inputQuanity) < 1) {
                setQuantitySelect(1);
                return;
            }

            setQuantitySelect(parseInt(inputQuanity));
            return;
        } else {
            setQuantitySelect(1);
        }
    };
    // X??? l?? ch???n l???y d??? li???u b??? nh??? khi ch???n 1 m??u
    const handleSelectColor = (e) => {
        if (selectedColor == e.currentTarget.dataset.id) {
            setSelectedColor(0);
            setVariant({});
            setBoNhos([]);
            updateQuanity(detail.variants);
            return;
        }
        let name = e.currentTarget.dataset.name;
        setBoNhos(
            detail.variants.filter((vari) => {
                if (vari.color.includes(name)) {
                    return vari;
                }
            }),
        );

        setSelectedColor(e.currentTarget.dataset.id);
        if (quantitySelect != 1) setQuantitySelect(1);
    };

    // X??? l?? ch???n b??? nh??? c???p nh???t s??? ti???n; ramid, romid
    const handleSelectBoNho = (e) => {
        if (selectedRam == e.currentTarget.dataset.ramid && selectedRom == e.currentTarget.dataset.romid) {
            setSelectedRam(0);
            setSelectedRom(0);
            updateQuanity(detail.variants);
            return;
        }
        let percentPrice =  parseFloat(e.currentTarget.dataset.percentprice);
        let ramId = e.currentTarget.dataset.ramid;
        let romId = e.currentTarget.dataset.romid;
        setPrice(parseFloat(detail.phone.priceSale) * parseFloat(1 + (percentPrice / 100)));
        setSelectedRom(romId);
        setSelectedRam(ramId);
        if (quantitySelect != 1) setQuantitySelect(1);
    };

    // X??? l?? ch???n bi???n th??? c??? th??? th??ng qua colorid, ramid, romid
    useEffect(() => {
        if (selectedColor && selectedRam && selectedRom) {
            let variTemp = detail.variants.filter((vari) => {
                if (vari.colorId == selectedColor && vari.ramId == selectedRam && vari.romId == selectedRom) {
                    setQuantity(vari.quantity);
                    return vari;
                }
            });

            setVariant(...variTemp);
        }
    }, [selectedColor, selectedRam, selectedRom, detail]);

    function storeOrrerApi(btn) {
        {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    customerId: user.id,
                    item: {
                        phoneId: detail.phone.id,
                        imgUrl: detail.phone.imgUrl,
                        phoneDetailId: variant.id,
                        quantity: quantitySelect,
                        priceSale: price,
                        totalMoney: price * quantitySelect,
                    },
                }),
            };
            fetch('/api/cart', requestOptions)
                .then((response) => response.json())
                .then((data) => (btn == 'add') ? setCartChange(data.data.id): setSelectedCartId(data.data.id));
        }
    }

    // X??? l?? th??m v??o gi??? h??ng
    const handleAddToCart = () => {
        if (user != null) {
            if (selectedColor && selectedRam && selectedRom) {
                storeOrrerApi('add');
                api.success({
                    message: 'Th??m v??o gi??? h??ng th??nh c??ng',
                    // description:
                    //     'C???m ??n qu?? kh??ch ???? tin t?????ng!',
                    duration: 2,
                });
            }
        } else {
            navigate('/login');
            api.error({
                message: 'Vui l??ng ????ng nh???p',
                // description:
                //     'C???m ??n qu?? kh??ch ???? tin t?????ng!',
                duration: 2,
            });
        }

        setIsError(!(selectedColor && selectedRam && selectedRom) ? true : false);
    };

    const handleBuy = () => {

        if (user != null) {
            if (selectedColor && selectedRam && selectedRom) {
                storeOrrerApi('buy');
                api.success({
                    message: 'Th??m v??o gi??? h??ng th??nh c??ng',
                    duration: 2,
                });
                navigate('/cart');
            }
        } else {
            navigate('/login');
            api.error({
                message: 'Vui l??ng ????ng nh???p',
                // description:
                //     'C???m ??n qu?? kh??ch ???? tin t?????ng!',
                duration: 2,
            });
        }
        setIsError(!(selectedColor && selectedRam && selectedRom) ? true : false);
       
       
    };
    return (
        <WarpperStyled>
            {loaded && (
                <WarpperDetailStyled>
                    {contextHolder}
                    <WarpperLinkStyled>
                        <Link className={cx('product-link')} to={'/'}>
                            Trang ch???
                        </Link>
                        <span> &gt; </span>
                        <Link className={cx('product-link')} to={'/'}>
                            iPhone
                        </Link>
                        <span> &gt; </span>
                        <Link className={cx('product-link')} to={'/'}>
                            iPhone 13 ProMax
                        </Link>
                    </WarpperLinkStyled>

                    {/* Khung chia ti???t s???n ph???m */}
                    <DetailStyled>
                        <Row className="product">
                            <Col span={8}>
                                <Img preview={false} className="product__img" src={detail.phone.imgUrl}></Img>
                            </Col>
                            <Col span={10}>
                                <Row>
                                    <Typography.Title className="product__ten" level={3}>
                                        {detail.phone.name}
                                    </Typography.Title>
                                </Row>
                                <Row>
                                    <Typography.Title level={3} type="danger" className="product__gia">
                                        {formatVND(price)}
                                    </Typography.Title>
                                </Row>
                                <Row>
                                    <Col span={4}>
                                        {' '}
                                        <Typography.Text className="product__tinhTrang">T??nh tr???ng</Typography.Text>
                                    </Col>
                                    <Col span={4}>
                                        {' '}
                                        <Typography.Text className="product__tinhTrang">
                                            {quantity ? 'C??n h??ng' : 'H???t h??ng'}
                                        </Typography.Text>
                                    </Col>
                                </Row>
                                <div className={`${isError ? 'error' : ''}`}>
                                    <Row>
                                        <ButtonStyled lassName="product__mau">
                                            <Col span={4}>
                                                <Typography.Text className="product__mau_tieuDe">
                                                    Ch???n m??u
                                                </Typography.Text>
                                            </Col>
                                            <Col span={20}>
                                                {colors.map((color) => (
                                                    <Button
                                                        className={`mau ${selectedColor == color.id ? 'selected' : ''}`}
                                                        key={color.id}
                                                        data-id={color.id}
                                                        data-name={color.name}
                                                        shape="circle"
                                                        onClick={handleSelectColor}
                                                        size="large"
                                                    >
                                                        {color.name}
                                                    </Button>
                                                ))}
                                            </Col>
                                        </ButtonStyled>
                                    </Row>
                                    <Row>
                                        <ButtonStyled className="product__boNho">
                                            <Col span={4}>
                                                <Typography.Text>B??? nh???</Typography.Text>
                                            </Col>

                                            <Col span={20}>
                                                {selectedColor ? (
                                                    boNhos.map((boNho) => (
                                                        <Button
                                                            className={`boNho ${
                                                                selectedRam == boNho.ramId && selectedRom == boNho.romId
                                                                    ? 'selected'
                                                                    : ''
                                                            }`}
                                                            key={boNho.id}
                                                            size="large"
                                                            data-ramid={boNho.ramId}
                                                            data-romid={boNho.romId}
                                                            data-percentprice={boNho.percentPrice}
                                                            onClick={handleSelectBoNho}
                                                            ghost
                                                            danger
                                                        >
                                                            {boNho.ram}/{boNho.rom}
                                                        </Button>
                                                    ))
                                                ) : (
                                                    <Typography.Text type="danger">Vui l??ng ch???n m??u!</Typography.Text>
                                                )}
                                            </Col>
                                        </ButtonStyled>
                                    </Row>
                                    <Row>
                                        <Col span={24}>
                                            <ButtonStyled className="product__soLuong">
                                                <Col span={4}>
                                                    <Typography.Text>S??? l?????ng</Typography.Text>
                                                </Col>
                                                <Col span={6}>
                                                    <Button
                                                        icon={<MinusOutlined></MinusOutlined>}
                                                        onClick={handleDecrease}
                                                    ></Button>
                                                    <Input
                                                        value={quantitySelect}
                                                        size="small"
                                                        onChange={handleInputChangeQuanity}
                                                    />
                                                    <Button
                                                        icon={<PlusOutlined></PlusOutlined>}
                                                        onClick={handleIncrease}
                                                    ></Button>
                                                </Col>
                                                <Col>
                                                    <Typography.Text>
                                                        {selectedColor && selectedRam && selectedRom && variant
                                                            ? variant.quantity
                                                            : quantity}{' '}
                                                        S???n ph???m s???n c??
                                                    </Typography.Text>
                                                </Col>
                                            </ButtonStyled>
                                        </Col>
                                    </Row>
                                    {isError && (
                                        <Row className="errContent">
                                            <Col span={24}>
                                                <Typography.Text type="danger">Vui l??ng ch???n</Typography.Text>
                                            </Col>
                                        </Row>
                                    )}
                                </div>

                                <Row>
                                    <DescriptionsStyled title="Khuy???n m??i" bordered>
                                        <Descriptions.Item className="product__noiDungKhuyenMai">
                                            FLASH SALE: T???ng voucher 500.000?? gi???m tr???c ti???p v??o gi?? m??y Duy nh???t t???i
                                            Dienthoaihay: iPhone ch??nh h??ng VN/A r??? nh?? h??ng c?? x??ch tay Tr??? gi?? mua c???
                                            s???c nhanh 20W PD ch??nh h??ng ch??? 250k Tr??? g??p nhanh, l??i su???t 0% qua th??? t??n
                                            d???ng Mua Online: Giao h??ng t???n nh??- Nh???n h??ng thanh to??n Th??? SIM: Nano +
                                            eSim M??n h??nh: 6.7 inches, Super Retina XDR OLED, 120Hz, HDR10, Dolby
                                        </Descriptions.Item>
                                    </DescriptionsStyled>
                                    {/* <Typography.Text className='product__khuyenMai'>Khuy???n m??i</Typography.Text>
                                <Typography.Text className='product__noiDungKhuyenMai'>
                                    FLASH SALE: T???ng voucher 500.000?? gi???m tr???c ti???p v??o gi?? m??y
                                    Duy nh???t t???i Dienthoaihay: iPhone ch??nh h??ng VN/A r??? nh?? h??ng c?? x??ch tay
                                    Tr??? gi?? mua c??? s???c nhanh 20W PD ch??nh h??ng ch??? 250k
                                    Tr??? g??p nhanh, l??i su???t 0% qua th??? t??n d???ng
                                    Mua Online: Giao h??ng t???n nh??- Nh???n h??ng thanh to??n
                                    Th??? SIM: Nano + eSim M??n h??nh: 6.7 inches, Super Retina XDR OLED, 120Hz, HDR10, Dolby
                             
                                </Typography.Text> */}
                                </Row>

                                <Row>
                                    <Col span={24}>
                                        <WarpperButtonHandleStyled>
                                            <Button className="btn btn_add" size="large" onClick={handleAddToCart}>
                                                Th??m v??o gi??? h??ng
                                            </Button>
                                            <Button className="btn btn_buy" size="large" onClick={handleBuy}>
                                                Mua ngay
                                            </Button>
                                        </WarpperButtonHandleStyled>
                                    </Col>
                                </Row>
                            </Col>

                            <Col span={6}>
                                <WarpperThongSoStyled>
                                    <DescriptionsStyled bordered column={1}>
                                        <Descriptions.Item className="product_thongSo">
                                            Th??ng s??? k??? thu???t
                                        </Descriptions.Item>
                                        <Descriptions.Item className="product__noiDungThongSo">
                                            FLASH SALE: T???ng voucher 500.000?? gi???m tr???c ti???p v??o gi?? m??y Duy nh???t t???i
                                            Dienthoaihay: iPhone ch??nh h??ng VN/A r??? nh?? h??ng c?? x??ch tay Tr??? gi?? mua c???
                                            s???c nhanh 20W PD ch??nh h??ng ch??? 250k Tr??? g??p nhanh, l??i su???t 0% qua th??? t??n
                                            d???ng Mua Online: Giao h??ng t???n nh??- Nh???n h??ng thanh to??n Th??? SIM: Nano +
                                            eSim M??n h??nh: 6.7 inches, Super Retina XDR OLED, 120Hz, HDR10, Dolby
                                        </Descriptions.Item>
                                    </DescriptionsStyled>
                                </WarpperThongSoStyled>

                                {/* <Row><Typography.Text>Th??ng tin s???n ph???m</Typography.Text></Row>
                            <Row>
                            <Typography.Text>
                                Th??? SIM: Nano + eSim M??n h??nh: 6.7 inches, Super Retina XDR OLED, 120Hz, HDR10, Dolby
                                Vision ????? ph??n gi???i: 1284 x 2778 pixels, t??? l??? 19.5:9 CPU: Apple A15 Bionic (5 nm) RAM:
                                6GB B??? nh???/ Th??? nh???: 128/256/512GB/1TB Camera sau: 12 MP, f/1.5, 26mm (wide), 1.9??m,
                                dual pixel PDAF, sensor-shift OIS, 12 MP, 12 MP
                                Th??? SIM: Nano + eSim M??n h??nh: 6.7 inches, Super Retina XDR OLED, 120Hz, HDR10, Dolby
                                Vision ????? ph??n gi???i: 1284 x 2778 pixels, t??? l??? 19.5:9 CPU: Apple A15 Bionic (5 nm) RAM:
                                6GB B??? nh???/ Th??? nh???: 128/256/512GB/1TB Camera sau: 12 MP, f/1.5, 26mm (wide), 1.9??m,
                                dual pixel PDAF, sensor-shift OIS, 12 MP, 12 MP
                                
                            </Typography.Text>
                            </Row> */}
                            </Col>
                        </Row>
                    </DetailStyled>
                </WarpperDetailStyled>
            )}
        </WarpperStyled>
    );
}

export default ProcductDetail;
