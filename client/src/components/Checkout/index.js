import React, { useEffect, useState } from 'react';
// import { images as imgs } from '~/assets/images';
import images from '~/assets/images';
import { AppContext } from '~/Context/AppProvider';
import { useLocalStorage } from '~/hooks/useLocalStorage';
import { Row, Col, Typography, Image, Input, Radio, Select, Button, notification } from 'antd';
import Styled from 'styled-components';
import formatVND from '~/utilis';
import styled from 'styled-components';

const styles = {
    productInfo: 'bg-[#D9D9D9] p-6',
    titleContainer: 'bg-white py-3 flex font-semibold text-sm md:text-base text-center px-1 sm:px-6',
    titleProductLg: 'basis-3/12',
    titleProduct: 'basis-3/12 md:basis-2/12',
    itemContainer: 'h-20 overflow-hidden bg-white mt-3 flex px-1 sm:px-6',
    itemLg: 'basis-3/12 py-3 text-sm sm:text-sm md:text-base my-auto',
    item: 'basis-3/12 md:basis-2/12 text-center py-3 text-xs sm:text-sm md:text-base my-auto',
    hide: 'hidden md:block',
    priceContainer: 'flex justify-end md:text-xl font-bold my-6',
    priceContent: 'text-[#2A254B]',
    totalPrice: 'text-[#D82828] ml-8',
    userInfo: 'p-6',
    heading: 'font-bold',
    userInfoContainer: 'my-8 md:mx-12',
    inputItemContainer: 'mb-3 flex',
    title: 'basis-2/12 ',
    input: 'basis-10/12 outline-none border border-black rounded px-2 py-1',
    inputXs: 'basis-4/12 md:basis-5/12',
    inputSm: 'md:basis-6/12 lg:basis-5/12',
    inputLg: 'md:basis-10/12',
    btnCheck:
        'basis-auto bg-[#2A254B] text-white px-3 py-2 rounded-lg ml-2 md:ml-8 hover:bg-yellow-500 transition delay-150 duration-300 ease-in-out',
    radioInput: 'mr-2',
    radioLabel: 'mr-8',
    btnContainer: 'grid',
    btnCheckout:
        'px-4 py-2 bg-[#D82828] text-white font-semibold place-self-end hover:cursor-pointer animate-bounce hover:animate-none hover:text-white hover:bg-yellow-500 transition ease-in-out delay-100 duration-200',
};

const WarpperTitleStyled = Styled.div`
    background: #fff;
    padding: 10px 0;
    font-weight: bold;
    border-radius: 2px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);

    .title_product_img, .title_product_quantity, .title_product_price {
        text-align: center;
       
    }
    .title_product_total {
        text-align: right;
    }
`;

const WarpperProductStyled = Styled.div`
    background: #fff;
    margin: 5px 0;
    border-radius: 2px;
    height: 70px;
    padding: 10px 0;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);

    overflow: hidden;
    .product_img {
        display: flex;
        justify-content: center;
    }
    .product_img__img {
       width: 50px;
    }
    .product_name {
        font-size: 14px;
        display: flex;
        align-items: center;
    }
    .product_quantity, .product_price {
        display: block;
        text-align: center;
        margin: auto 0;
    }

    .product_total {
        display: block;
        text-align: right;
        margin: auto 0;
    }
`;

const ProductWrap = styled.div`
    margin: 40px 20px;
    border-radius: 5px;
`;

const Payment = styled(Row)`
    font-size: 16px;
    font-weight: 400;
    .payment {
        text-align: end;
    }
`;

const BtnPurchase = styled(Button)`
    width: 150px;
    height: 40px;
    background-color: red;
    font-size: 16px;
    font-weight: 500;
    color: #fff;
    text-align: center;
    border: 1px solid #000;
`;

function Checkout() {
    const [api, contextHolder] = notification.useNotification();
    const [savedLocalCheckout, setSavedLocalCheckout, clearLocalStorage] = useLocalStorage('checkout');
    const [savedLocalUser, setSavedLocalUser, clearLocalStorageUser] = useLocalStorage('user');
    const { setIsOrdering } = React.useContext(AppContext);
    const [checkout, setCkeckout] = useState(savedLocalCheckout());
    const [user, setUser] = useState(savedLocalUser());
    const [shipMethod, setShipMethod] = useState([]);
    const [feeShip, setFeeShip] = useState(0);
    const [paymentMethod, setPaymentMethod] = useState([]);
    const [selectedPayment, setSelectedPayment] = useState(0);
    const [selectedNamePayment, setSelectedNamePayment] = useState('');
    const [selectedAdress, setSelectedAress] = useState(1);
    const [isLoadingMethod, setIsLoaddingMethod] = useState(false);
    const [isCheckedShip, setIsCheckedShip] = useState(0);
    const [totalMoney, setTotalMoney] = useState(
        checkout ? checkout.reduce((total, ck) => total + ck.totalMoney, 0) : 0,
    );

    // const {carts, cartId} = React.useContext(AppContext);
    if (!checkout) window.location.href = '/';
    useEffect(() => {
        fetch('/api/ship')
            .then((data) => data.json())
            .then((res) => {
                setShipMethod(res);
                setIsCheckedShip(res[0].id);
                setFeeShip(res[0].feePrice);
            })
            .catch((err) => console.log(err));

        fetch('/api/payment')
            .then((data) => data.json())
            .then((res) => {
                setPaymentMethod(res);
                setSelectedNamePayment(res[0].name);
                setSelectedPayment(res[0].id);
                setIsLoaddingMethod(true);
            })
            .catch((err) => console.log(err));
    }, []);

    const handleOrder = () => {
        if (selectedAdress && selectedPayment && isCheckedShip) {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    customerId: user.id,
                    paymentId: selectedPayment,
                    shipId: isCheckedShip,
                    addressReceiveId: selectedAdress,
                    statusId: 1,
                    cartItemId: checkout.map((ck) => ck.id),
                    noteMess: 'chu y',
                }),
            };
            fetch('/api/order', requestOptions)
                .then((response) => response.json())
                .then((data) => {
                    console.log(',,,', data);
                    setIsOrdering(checkout.map((ck) => ck.id));
                    clearLocalStorage();
                });

            api.success({
                message: '?????t h??ng th??nh c??ng',
                description: 'C???m ??n qu?? kh??ch ???? tin t?????ng!',
                duration: 0,
            });
        } else {
            console.log('kh??ng ?????t ???????c h??ng');
        }
    };

    const handleChangePayment = (value) => {
        setSelectedPayment(value);
    };
    console.log('paymentname', selectedNamePayment);
    console.log('paymentname', isLoadingMethod);
    // console.log('shipMethod', shipMethod)
    // console.log('isCheckedShip', isCheckedShip)
    // // console.log('freeShip', freeShip)
    // console.log('totalMoney', totalMoney)
    // console.log('paymentMethod', paymentMethod[0]?paymentMethod[0].id:'')
    return (
        <div className={styles.checkout}>
            {contextHolder}
            <ProductWrap className={styles.productInfo}>
                {}
                {/* <div className={styles.titleContainer}>
                    <span className={styles.titleProductLg}>T??n s???n ph???m</span>
                    <span className={`${styles.titleProductLg} ${styles.hide}`}>H??nh ???nh</span>
                    <span className={styles.titleProduct}>S??? l?????ng</span>
                    <span className={styles.titleProduct}>????n gi??</span>
                    <span className={styles.titleProduct}>Th??nh ti???n</span>
                </div> */}
                <Typography.Title level={5}>S???n ph???m</Typography.Title>
                <WarpperTitleStyled>
                    <Row>
                        <Col className="title_product_img" span={3}>
                            <Typography.Text>H??nh ???nh</Typography.Text>
                        </Col>
                        <Col className="title_product_name" span={11}>
                            <Typography.Text>T??n s???n ph???m</Typography.Text>
                        </Col>

                        <Col className="title_product_quantity" span={2}>
                            <Typography.Text>S??? l?????ng</Typography.Text>
                        </Col>
                        <Col className="title_product_price" span={2}>
                            <Typography.Text>????n gi??</Typography.Text>
                        </Col>
                        <Col className="title_product_total" span={5}>
                            <Typography.Text>Th??nh ti???n</Typography.Text>
                        </Col>
                    </Row>
                </WarpperTitleStyled>

                {checkout.map((ck) => (
                    <WarpperProductStyled key={ck.id}>
                        <Row>
                            <Col span={3} className="product_img">
                                <Image
                                    className="product_img__img"
                                    src={
                                        'https://cdn.didongviet.vn/pub/media/catalog/product//i/p/iphone-14-plus-128gb-didongviet.jpg'
                                    }
                                    alt="1111"
                                ></Image>
                            </Col>
                            <Col span={11} className="product_name">
                                <Typography.Text>{ck.phoneName}</Typography.Text>
                            </Col>

                            <Col span={2} className="product_quantity">
                                <Typography.Text>{ck.quantity}</Typography.Text>
                            </Col>
                            <Col span={2} className="product_price">
                                <Typography.Text>{formatVND(ck.priceSale*0.9)}</Typography.Text>
                            </Col>
                            <Col span={5} className="product_total">
                                <Typography.Text>{formatVND(ck.totalMoney)}</Typography.Text>
                            </Col>
                        </Row>
                    </WarpperProductStyled>
                ))}
            </ProductWrap>
            <div className={styles.userInfo}>
                <div className={styles.heading}>Th??ng tin ?????t h??ng</div>
                <div className={styles.userInfoContainer}>
                    <div className={styles.inputItemContainer}>
                        <span className={styles.titleProduct}>H??? v?? t??n:</span>
                        <Input className={`${styles.input} ${styles.inputSm}`} value={user.name} type="text" />
                    </div>
                    <div className={styles.inputItemContainer}>
                        <span className={styles.titleProduct}>S??T:</span>
                        <Input className={`${styles.input} ${styles.inputSm}`} type="phone" value={user.phoneNumber} />
                    </div>
                    <div className={styles.inputItemContainer}>
                        <span className={styles.titleProduct}>Email:</span>
                        <Input className={`${styles.input} ${styles.inputSm}`} type="email" value={user.email} />
                    </div>
                    <div className={styles.inputItemContainer}>
                        <span className={styles.title}>?????a ch???:</span>
                        <Input className={`${styles.input} ${styles.inputLg}`} type="text" value={user.address} />
                    </div>

                    <div className={styles.inputItemContainer}>
                        <span className={styles.title}>Ph????ng th???c thanh to??n:</span>
                        <Select
                            defaultValue={isLoadingMethod ? selectedNamePayment : '-Ch???n-'}
                            style={{
                                width: 200,
                            }}
                            onChange={handleChangePayment}
                            options={
                                paymentMethod &&
                                paymentMethod.map((payment) => ({
                                    value: payment.id,
                                    label: payment.name,
                                }))
                            }
                        />
                    </div>

                    <div className={styles.inputItemContainer}>
                        <span className={styles.title}>V???n chuy???n:</span>
                        <Radio.Group value={isCheckedShip}>
                            {shipMethod &&
                                shipMethod.map((ship) => (
                                    <Radio
                                        key={ship.id}
                                        value={ship.id}
                                        onChange={() => {
                                            setIsCheckedShip(ship.id);
                                            setFeeShip(ship.feePrice);
                                        }}
                                    >
                                        {ship.name}
                                    </Radio>
                                ))}
                        </Radio.Group>
                    </div>

                    <div className={styles.inputItemContainer}>
                        <span className={styles.title}>Ghi ch??:</span>
                        <textarea className={`${styles.input}`} name="message" rows="4"></textarea>
                    </div>
                    <div>
                        <Payment>
                            <Col span={20}></Col>
                            <Col span={4}>
                                <Row>
                                    <Col span={14} className="paymentTitle">
                                        T???ng ti???n h??ng:
                                    </Col>
                                    <Col span={10} className="payment">
                                        {formatVND(totalMoney)}
                                    </Col>
                                </Row>
                                <Row>
                                    <Col span={14}>Ti???n v???n chuy???n:</Col>
                                    <Col span={10} className="payment">
                                        {formatVND(feeShip)}
                                    </Col>
                                </Row>
                                <Row>
                                    <Col span={14}>Thanh to??n:</Col>
                                    <Col span={10} className="payment">
                                        <Typography.Text type="danger">{formatVND(parseFloat(totalMoney) + parseFloat(feeShip))}</Typography.Text>
                                        
                                    </Col>
                                </Row>
                            </Col>
                        </Payment>
                        <Row className={styles.btnContainer} style={{ textAlign: 'end' }}>
                            {/* <input className={styles.btnCheckout} type="submit" name="btnCheckout" value="G???I H??NG (COD)" /> */}

                            <Col span={24} style={{ textAlign: 'right' }}>
                                <BtnPurchase onClick={handleOrder}>?????t h??ng</BtnPurchase>
                            </Col>
                        </Row>
                    </div>
                </div>
            </div>
        </div>
    );
}
export default Checkout;
