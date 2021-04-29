@extends('layouts.app')

@section('pagescss')
<link rel="stylesheet" href="/css/main/pay&del.css">
@endsection

@section('title', 'Payment and delivery')

@section('content')
<section class="section">
  <div class="container">
    <h1 class="text-center paytittle">Payment and delivery</h1>
    <div class="row">
        <button class="btn pay col-lg-3 col-md-6 col-sm-12" type="button" data-toggle="collapse" data-target="#collapseExample_1" aria-expanded="true" aria-controls="collapseExample_1">
          Ways of payment
        </button>
        <button class="btn pay col-lg-3 col-md-6 col-sm-12" type="button" data-toggle="collapse" data-target="#collapseExample_2" aria-expanded="false" aria-controls="collapseExample_2">
          Delivery in Baku
        </button>
        <button class="btn pay col-lg-3 col-md-6 col-sm-12" type="button" data-toggle="collapse" data-target="#collapseExample_3" aria-expanded="false" aria-controls="collapseExample_3">
          Receiving the goods
        </button>
        <button class="btn pay col-lg-3 col-md-6 col-sm-12" type="button" data-toggle="collapse" data-target="#collapseExample_4" aria-expanded="false" aria-controls="collapseExample_4">
          Our details
        </button>
    </div>
    <div id="collapse_card_group">
        <div class="collapse show" id="collapseExample_1" data-parent="#collapse_card_group">
            <h2 class="text-center mt-3 mb-5">Ways of payment</h2>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="fst-column">
                      <img class="cardimg" src="/img/pay&del/wallet.png">
                      <div>
                        <h5>Cash payment</h5>
                        <h6>Cash payment at the time of receipt of the order upon delivery or at the checkout of the store</h6>
                      </div><!--Flexbox-->
                    </div>
                    <div class="fst-column">
                      <img class="cardimg" src="/img/pay&del/card.png">
                      <div>
                        <h5>Payment by debit card</h5>
                        <h6>It is carried out with the help of such and such protected functionality</h6>
                      </div><!--Flexbox-->
                    </div>
                    <div class="fst-column">
                      <img class="cardimg" src="/img/pay&del/receipt.png">
                      <div>
                        <h5>Cashless payment by invoice</h5>
                        <h6 class="paytext">Payment is available to all legal entities and individuals.
                            After placing an order, within 1 working hour, an invoice will be sent to you by e-mail or fax.
                            No commission is charged.
                            Prices when paying by bank transfer including VAT are the same as for cash</h6>
                      </div><!--Flexbox-->
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                  <div class="snd-column">
                    <img class="cardimg" src="/img/pay&del/wallet.png">
                    <div>
                      <h5>Cash payment</h5>
                      <h6>It is carried out with the help of such and such protected functionality</h6>
                    </div>
                  </div>
                  <div class="snd-column">
                    <img class="cardimg" src="/img/pay&del/card.png">
                    <div>
                      <h5>Payment by debit card</h5>
                      <h6>It is carried out with the help of such and such protected functionality</h6>
                    </div>
                  </div>
                  <div class="snd-column">
                    <img class="cardimg" src="/img/pay&del/receipt.png">
                    <div>
                      <h5>Cashless payment by invoice</h5>
                      <h6 class="paytext">Payment is available to all legal entities and individuals.
                          After placing an order, within 1 working hour, an invoice will be sent to you by e-mail or fax.
                          No commission is charged.
                          Prices when paying by bank transfer including VAT are the same as for cash</h6>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="collapse" id="collapseExample_2" data-parent="#collapse_card_group">
            <h2 class="text-center mt-3 mb-5">Delivery in Baku</h2>
            <div class="orderbox">
            <h5>Here you can arrange:</h5>
              <ul>
                <li>The first way</li>
                <li>Second way</li>
                <li>Third way</li>
              </ul>
            </div>
          <div class="delflex">
            <h3>Courier delivery</h3>
            <img class="delimg" src="/img/pay&del/delivery_1.png">
            <img class="delimg" src="/img/pay&del/delivery_2.png">
          </div><!--Flexbox-->
          <ul>
            <li>
              <h3>Delivery addresses</h3>
              <p>Delivery of goods purchased in our store is carried out daily - up to 100 km from the Moscow Ring Road of the center of Baku, etc.</p>
            </li>
            <li>
              <h3>Delivery rates</h3>
              <table class="table table-bordered table-dark">
                <thead>
                  <tr>
                    <th scope="col">Категория</th>
                    <th scope="col">10 km from center</th>
                    <th scope="col">Extra shipping</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1: Large equipment</th>
                    <td>10 AZN</td>
                    <td>15 AZN</td>
                  </tr>
                  <tr>
                    <th scope="row">2: Small-sized equipment</th>
                    <td>5 AZN</td>
                    <td>10 AZN</td>
                  </tr>
                  <tr>
                    <th scope="row">3: Accessories</th>
                    <td>3 AZN</td>
                    <td>5 AZN</td>
                  </tr>
                </tbody>
              </table>
              <h4>Check in which zone your address is.</h4>
              <iframe class="googleadr" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d68728.48524067987!2d49.839460042394975!3d40.42217134803343!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40307d6bd6211cf9%3A0x343f6b5e7ae56c6b!2z0JHQsNC60YMsINCQ0LfQtdGA0LHQsNC50LTQttCw0L0!5e0!3m2!1sru!2s!4v1599489736165!5m2!1sru!2s"></iframe>
            </li>
            <li>
              <h3 class="mt-3 mb-5">Time of delivery</h3>
              <div class="row delboxeshead">
                <div class="delboxes">
                  <h3 class="ml-3">Delivery</h3>
                  <h6 class="ml-3">on the day of order</h6>
                    <div class="bgbox mb-3">
                    <div class="bgboxtext_1"><i class="fa fa-check mt-2"></i>Order placed before 15:00</div>
                    <div class="bgboxtext_1"><i class="fa fa-check"></i>Goods with the status "In stock"<br></div>
                    <div class="bgboxtext_1"><i class="fas fa-exclamation-circle mt-3 mb-2"></i>Check with the operator for details</div>
                    </div>
                </div>
                <div class="delboxes">
                  <h3 class="ml-3">Delivery</h3>
                  <h6 class="ml-3">at a certain period of time</h6>
                    <div class="bgbox">
                      <div class="bgboxtext_1"><b>+50%</b> to the shipping cost</div>
                      <div class="bgboxtext_2 mt-3">
                            Before lunch	10:00 - 13:00<br>
                            At lunch	13:00 - 16:00<br>
                            At the end of the day	16:00 - 19:00<br>
                            In the evening	19:00 - 22:00
                      </div>
                    </div>
                </div>
                <div class="delboxes">
                  <h3 class="ml-3">Delivery</h3>
                  <h6 class="ml-3">at the exact time</h6>
                    <div class="bgbox">
                        <div class="text-center"><b>+100%</b> to the shipping cost</div>
                        <img class="delintimeimg" src="/img/pay&del/delintime.png">
                    </div>
                </div>
             </div>
            </li>
          </ul>
        </div>
        <div class="collapse" id="collapseExample_3" data-parent="#collapse_card_group">
            <h2 class="text-center mt-3">Receiving the goods</h2>
            <h5 class="text-danger">Be sure to make sure that there are no mechanical damage to the package (jams, breaks, breaks) before signing the delivery documents and accepting the goods.</h5>
            <div class="acceptbox">
              <span class="text-danger"><strong>Помните!</strong><br>
                    Random Text...</span>
            </div>
            <h2>Please note the following:</h2>
            <ul>
              <li>Installation and connection of equipment by delivery staff is not carried out!</li>
              <li>Delivery service workers do not have the necessary qualifications to install and test devices. Read the instructions carefully before using the device! Do not under any circumstances violate the conditions of the instructions, this may lead to the impossibility of performing warranty repairs.!</li>
              <li>The buyer has the right to demand that the device be turned on to check its operability, but at the same time it is necessary to know that in the future there may be problems with the operation of the product due to incorrect initial switching on (refers to the winter season). According to the rules of operation, before switching on, the temperature of the device must be at room temperature. Typically, the temperature balance is reached within 2-6 hours. Especially important for digital goods, audio and video equipment and other goods with complex electronics.</li>
            </ul>

        </div>
        <div class="collapse" id="collapseExample_4" data-parent="#collapse_card_group">
            <h2 class="text-center mt-3 mb-5">Our details</h2>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Organization name</th>
                  <th scope="col">Something</th>
                  <th scope="col">Something</th>
                  <th scope="col">Something</th>
                  <th scope="col">Something</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">Requisites</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Requisites</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>ЧSomething</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>SomethingSomething</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Requisites</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>SomethingSomething</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>

                <tr>
                  <th scope="row">Requisites</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Requisites</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
                <tr>
                  <th scope="row">Something else</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                  <th>Something</th>
                </tr>
              </tbody>
            </table>
        </div>
    </div>
  </div><!--End container-->
  <div class="w-100 text-center">
    <img class="payanddelimg" src="/img/pay&del/pay&delimg.png ">
  </div>
</section>
@endsection
