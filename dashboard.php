<?php
@session_start();
include 'Services/Twilio/Capability.php';
$username = '';
$imageurl = 'images/user.png';
if (!isset($_SESSION["userid"])) {
    header("location:index.php");
} else {
    //$clientName = $_SESSION["userid"];
    $username = $_SESSION["username"];
    if (isset($_SESSION["imageurl"]) && $_SESSION["imageurl"] != null) {
        $imageurl = $_SESSION["imageurl"];
    }
}
// put your Twilio API credentials here
$accountSid = 'AC50bcbef90dd37cf6f5cb5f8ef13964c9';
$authToken = '49d0225d70d46d9e57324e98c48d3b22';
$sqootApiKey = 'f07pod';
// put your Twilio Application Sid here
$appSid = 'APa3f3e49d38f8f607c580e1d82ac82b96';

$capability = new Services_Twilio_Capability($accountSid, $authToken);
$capability->allowClientOutgoing($appSid);
$capability->allowClientIncoming('support');
$token = $capability->generateToken();
?>
<!doctype html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
        <title>Dashboard</title>
        <link href="css/bootstrap.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" />
        <link href="css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css">
        <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
    </head>
    <body>
        <div class="wrapper">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-9 nopaddingrt header-left">
                            <div class="brow">
                                <div class="brow_ard pull-left">
                                    <div class="pull-left">
                                        <i class="fa  fa-map-marker pull-left"></i>
                                        <div class="pull-right valign">
                                            <span class="country city">BROWARD</span>
                                            <p class="state">FLORIDA 33311</p>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <div class="pull-left temp_day forecast" onclick="showForeCast()">
                                            <span class="temp"><label id="temp">89</label>°</span>
                                            <p class="day">SUNDAY</p>
                                        </div>
                                        <i class="fa fa-caret-left pull-right"></i>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="rating pull-right">
                                    <div class="pull-left left_border">
                                        <h1>RATING</h1>
                                        <h1>OVERVIEW</h1>
                                        <p>CALLER SATISFACTION</p>
                                    </div>
                                    <div class="pull-left">
                                        <img src="images/ratingstar1.png" alt=""></div>
                                    <div class="pull-right call-box">
                                        <h2 class="call">CALL TIME <span id="timer">00:00</span></h2>
                                        <div class="btn-hangup"><span onclick="hangup();">Hang Up Call</span></div>
                                    </div>

                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="customer">
                                <div class="line"></div>
                                <div class="pull-left">
                                    <h1><?php echo $username; ?></h1>
                                    <p>CUSTOMER SERVICE REP</p>
                                    <div class="checkbox check-primary">
                                        <input id="LOG" type="checkbox" value="1">
                                        <label for="LOG"><a href="logout.php" style="color:#fff;">LOG ME OUT</a></label>
                                    </div>
                                </div>
                                <div class="profile pull-right">
                                    <img src="<?php echo $imageurl; ?>" alt="" />
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <div class="main_box">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-9">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="caller">
                                            <div class="caller_img">
                                                <img id="callerimage" src="images/caller.png" />
                                                <div class="remaining_calls">
                                                    <span class="nunber pull-left">2</span> <span class="remainings pull-right">CALLS<br />
                                                        REMAINING</span>
                                                </div>
                                            </div>
                                            <h2 id="callername">Ed Leon</h2>
                                            <h3 id="callernumber">(502) 553-97 05</h3>
                                            <h1 id="callerlevel">MEMBERSHIP LEVEL</h1>
                                            <div class="caller_device">
                                                <div class="apple"><i class="fa fa-apple"></i></div>
                                                <span class="left">CALLER</span><span class="right">DEVICE</span>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-8">
                                        <div class="accordions">
                                            <div class="panel-group" id="accordion">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-caret-right"></i>BASIC INFORMATION </a></h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <div class="col-xs-6">
                                                                <label for="">Address:</label>
                                                                <input type="text" id="inputAddress" name="" value="" placeholder="" />
                                                                <br />
                                                                <label for="">Phone:</label>
                                                                <input type="text" id="inputPhone" name="" value="" placeholder="" />
                                                                <br />
                                                                <label for="">City:</label>
                                                                <input type="text" id="inputCity" name="" value="" placeholder="" />
                                                                <br />
                                                                <label for="">State:</label>
                                                                <input class="state" type="text" id="inputState" name="" value="" placeholder="" />
                                                                <label class="text-center" for="">Zip:</label>
                                                                <input class="zip" type="text" id="inputZip" name="" value="" placeholder="" />
                                                                <br />
                                                                <label for="">Email:</label>
                                                                <input type="text" id="inputEmail" name="" value="" placeholder="" />
                                                            </div>
                                                            <div class="col-xs-6">
                                                                <label for="">Occupation:</label>
                                                                <input type="text" id="inputOccupation" name="" value="" placeholder="" />
                                                                <br />
                                                                <label for="">Company:</label>
                                                                <input type="text" id="inputCompany" name="" value="" placeholder="" />
                                                                <br />
                                                                <label for="">Address:</label>
                                                                <input type="text" id="inputCompanyAddress" name="" value="" placeholder="" />
                                                                <br />
                                                                <label for="">Phone:</label>
                                                                <input type="text" id="inputCompanyPhone" name="" value="" placeholder="" />
                                                                <br />
                                                                <label for="">Email:</label>
                                                                <input type="text" id="inputCompanyEmail" name="" value="" placeholder="" />
                                                            </div>
                                                            <div class="col-xs-12">
                                                                <label for="">Education: </label>
                                                                <select id="education">
                                                                    <option>GED</option>
                                                                    <option>Assoc.</option>
                                                                    <option>Degree</option>
                                                                    <option>Bachelors </option>
                                                                    <option>Masters</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default" style="display:none;">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-caret-right"></i>WORK </a></h4>
                                                    </div>
                                                    <div id="collapseTwo" class="panel-collapse collapse">
                                                        <div class="panel-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default" style="display:none;">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><i class="fa fa-caret-right"></i>EDUCATION </a></h4>
                                                    </div>
                                                    <div id="collapseThree" class="panel-collapse collapse">
                                                        <div class="panel-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><i class="fa fa-caret-right"></i>FAMILY </a></h4>
                                                    </div>
                                                    <div id="collapseFour" class="panel-collapse collapse">
                                                        <div class="panel-body family">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default" style="display:none;">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><i class="fa fa-caret-right"></i>HEALTH </a></h4>
                                                    </div>
                                                    <div id="collapseFive" class="panel-collapse collapse">
                                                        <div class="panel-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default" style="display:none;">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapseSix"><i class="fa fa-caret-right"></i>SOCIAL LINKS </a></h4>
                                                    </div>
                                                    <div id="collapseSix" class="panel-collapse collapse">
                                                        <div class="panel-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS. </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <div class="interests">
                                    <div class="interest_head clearfix"><i class="fa fa-map-marker"></i><span>INTERESTS</span></div>
                                    <input type="search" name="" value="" placeholder="Search" />
                                    <div class="row checkboxwrap">
                                        <div class="col-xs-12 col-sm-12 col-md-6 pull-left">
                                            <div class="checkbox check-primary">
                                                <input id="checkbox1" type="checkbox" value="1">
                                                <label for="checkbox1">Alternative Energy</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox2" type="checkbox" value="1">
                                                <label for="checkbox2">Anthropology</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox3" type="checkbox" value="1">
                                                <label for="checkbox3">Archeology</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox4" type="checkbox" value="1">
                                                <label for="checkbox4">Aviation/Aerospace</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox5" type="checkbox" value="1">
                                                <label for="checkbox5">Biomechanics</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox6" type="checkbox" value="1">
                                                <label for="checkbox6">Botany</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox7" type="checkbox" value="1">
                                                <label for="checkbox7">Environment</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox8" type="checkbox" value="1">
                                                <label for="checkbox8">Futurism</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox9" type="checkbox" value="1">
                                                <label for="checkbox9">Genetics</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox10" type="checkbox" value="1">
                                                <label for="checkbox10">Geoscience</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox11" type="checkbox" value="1">
                                                <label for="checkbox11">Linguistics</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox12" type="checkbox" value="1">
                                                <label for="checkbox12">Amateur Radio</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox13" type="checkbox" value="1">
                                                <label for="checkbox13">Anti-aging</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox14" type="checkbox" value="1">
                                                <label for="checkbox14">Astronomy</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox15" type="checkbox" value="1">
                                                <label for="checkbox15">Biology</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox16" type="checkbox" value="1">
                                                <label for="checkbox16">Biotech</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox17" type="checkbox" value="1">
                                                <label for="checkbox17">Electronics</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox18" type="checkbox" value="1">
                                                <label for="checkbox18">Evolution</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox19" type="checkbox" value="1">
                                                <label for="checkbox19">Gadgets</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox20" type="checkbox" value="1">
                                                <label for="checkbox20">Geography</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox21" type="checkbox" value="1">
                                                <label for="checkbox21">Kinesiology</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox22" type="checkbox" value="1">
                                                <label for="checkbox22">Machinery</label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6 pull-right">
                                            <div class="checkbox check-primary">
                                                <input id="checkbox111" type="checkbox" value="1">
                                                <label for="checkbox111">Linguistics</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox112" type="checkbox" value="1">
                                                <label for="checkbox112">Amateur Radio</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox113" type="checkbox" value="1">
                                                <label for="checkbox113">Anti-aging</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox114" type="checkbox" value="1">
                                                <label for="checkbox114">Astronomy</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox115" type="checkbox" value="1">
                                                <label for="checkbox115">Biology</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox116" type="checkbox" value="1">
                                                <label for="checkbox116">Biotech</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox117" type="checkbox" value="1">
                                                <label for="checkbox117">Electronics</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox118" type="checkbox" value="1">
                                                <label for="checkbox118">Evolution</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox119" type="checkbox" value="1">
                                                <label for="checkbox119">Gadgets</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox120" type="checkbox" value="1">
                                                <label for="checkbox120">Geography</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox121" type="checkbox" value="1">
                                                <label for="checkbox121">Kinesiology</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox122" type="checkbox" value="1">
                                                <label for="checkbox122">Machinery</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox101" type="checkbox" value="1">
                                                <label for="checkbox101">Alternative Energy</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox102" type="checkbox" value="1">
                                                <label for="checkbox102">Anthropology</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox103" type="checkbox" value="1">
                                                <label for="checkbox103">Archeology</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox104" type="checkbox" value="1">
                                                <label for="checkbox104">Aviation/Aerospace</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox105" type="checkbox" value="1">
                                                <label for="checkbox105">Biomechanics</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox106" type="checkbox" value="1">
                                                <label for="checkbox106">Botany</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox107" type="checkbox" value="1">
                                                <label for="checkbox107">Environment</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox108" type="checkbox" value="1">
                                                <label for="checkbox108">Futurism</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox109" type="checkbox" value="1">
                                                <label for="checkbox9">Genetics</label>
                                            </div>
                                            <div class="checkbox check-primary">
                                                <input id="checkbox110" type="checkbox" value="1">
                                                <label for="checkbox110">Geoscience</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vspace-10"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="row">
									<div class="col-xs-12 col-sm-12 col-md-9">
										<div class="map-wrapper">
											<div class="categories">
												<div class="categories-data">
													<div class="interest_head clearfix"><i class="fa fa-bars"></i><span>CATEGORIES</span></div>
													<input type="search" name="" value="" placeholder="Search" onkeyup="filterCategories(this.value);" />
													<div class="row checkboxwrap checkboxwrap-2">
                                                        <div class="vspace-5"></div>
														<div class="col-xs-12 col-sm-12 col-md-6 pull-left category-left">
															<!--<div class="checkbox check-primary">
																<input id="checkbox221" type="checkbox" value="1">
																<label for="checkbox221">Alternative Energy</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox222" type="checkbox" value="1">
																<label for="checkbox222">Anthropology</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox223" type="checkbox" value="1">
																<label for="checkbox23">Archeology</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox224" type="checkbox" value="1">
																<label for="checkbox224">Aviation/Aerospace</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox225" type="checkbox" value="1">
																<label for="checkbox225">Biomechanics</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox226" type="checkbox" value="1">
																<label for="checkbox226">Botany</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox227" type="checkbox" value="1">
																<label for="checkbox227">Amateur Radio</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox228" type="checkbox" value="1">
																<label for="checkbox228">Anti-aging</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox229" type="checkbox" value="1">
																<label for="checkbox229">Astronomy</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox230" type="checkbox" value="1">
																<label for="checkbox230">Biology</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox231" type="checkbox" value="1">
																<label for="checkbox231">Biotech</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox232" type="checkbox" value="1">
																<label for="checkbox232">Electronics</label>
															</div> -->
														</div>
														<div class="col-xs-12 col-sm-12 col-md-6  pull-right category-right">
															<!--<div class="checkbox check-primary">
																<input id="checkbox327" type="checkbox" value="1">
																<label for="checkbox327">Amateur Radio</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox328" type="checkbox" value="1">
																<label for="checkbox328">Anti-aging</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox329" type="checkbox" value="1">
																<label for="checkbox329">Astronomy</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox330" type="checkbox" value="1">
																<label for="checkbox330">Biology</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox331" type="checkbox" value="1">
																<label for="checkbox331">Biotech</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox332" type="checkbox" value="1">
																<label for="checkbox332">Electronics</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox321" type="checkbox" value="1">
																<label for="checkbox321">Alternative Energy</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox322" type="checkbox" value="1">
																<label for="checkbox322">Anthropology</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox323" type="checkbox" value="1">
																<label for="checkbox323">Archeology</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox324" type="checkbox" value="1">
																<label for="checkbox324">Aviation/Aerospace</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox325" type="checkbox" value="1">
																<label for="checkbox325">Biomechanics</label>
															</div>
															<div class="checkbox check-primary">
																<input id="checkbox326" type="checkbox" value="1">
																<label for="checkbox326">Botany</label>
															</div> -->
														</div>
													</div>
													<div class="clear"></div>												
													<div class="vspace-10"></div>
													<!--
													<div class="vspace-10"></div>
													-->
													<div class="router" style="display:none;">
														<div class="router_box">
															<img src="images/road.png" alt="">
															ROUTE</div>
														<div class="pull-left left_part">
															<label for="">TIME: </label>
															<input type="text" name="" value="" />
															<label for="">DISTANCE: </label>
															<input type="text" name="" value="" />
														</div>
														<div class="pull-right right_part">
															<label for="">TRAFFIC: </label>
															<input type="text" name="" value="" />
															<label for="">HOW: </label>
															<input type="text" name="" value="" />
														</div>
													</div>
												</div>
											</div>

											<style type="text/css">
												#map-canvas { 
													height: 500px;
													width: 100%;
												}
                                                #map-canvas img { max-width: inherit; }
												.controls {
													margin-top: 16px;
													border: 1px solid transparent;
													border-radius: 2px 0 0 2px;
													box-sizing: border-box;
													-moz-box-sizing: border-box;
													height: 32px;
													outline: none;
													box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
												}
												#pac-input {
													background-color: #fff;
													padding: 0 11px 0 13px;
													width: 400px;
													font-family: Roboto;
													font-size: 15px;
													font-weight: 300;
													text-overflow: ellipsis;
													float:right;
												}

												#pac-input:focus {
													border-color: #4d90fe;
													margin-left: -1px;
													padding-left: 14px;  /* Regular padding-left + 1. */
													width: 401px;
												}

												.pac-container {
													font-family: Roboto;
												}

												#type-selector {
													color: #fff;
													background-color: #4d90fe;
													padding: 5px 11px 0px 11px;
												}

												#type-selector label {
													font-family: Roboto;
													font-size: 13px;
													font-weight: 300;
												}
											</style>
											<input id="pac-input" class="controls" type="text" placeholder="Search Box">
											<div id="map-canvas"></div>
										</div>
									</div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <div class="deals clearfix">
                                            <i class="">
                                                <img src="images/labelimg.png" alt=""></i> <span>DAILY DEALS</span>
                                            <div class="featured">
                                                <div class="line"></div>
                                                <h2>Featured Today</h2>
                                                <p>SEPTEMBER 15, 2014</p>
                                            </div>
                                            <div class="panel-group" id="accordion">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse11"><i class="pull-left">
                                                                    <img src="images/cart.png" alt=""></i>
                                                                <div class="shop pull-left">
                                                                    <h1>SHOP</h1>
                                                                    <p>DESCRIPTION OF DEAL</p>
                                                                </div>
                                                                <i class="fa fa-caret-left pull-right"></i>
                                                                <div class="clear"></div>
                                                            </a></h4>
                                                    </div>
                                                    <div id="collapse11" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p>Text hear</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse12"><i class="pull-left">
                                                                    <img src="images/diner.png" alt=""></i>
                                                                <div class="shop pull-left">
                                                                    <h1>FOOD</h1>
                                                                    <p>DESCRIPTION OF DEAL</p>
                                                                </div>
                                                                <i class="fa fa-caret-left pull-right"></i>
                                                                <div class="clear"></div>
                                                            </a></h4>
                                                    </div>
                                                    <div id="collapse12" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p>Text hear</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse13"><i class="pull-left">
                                                                    <img src="images/cocktail.png" alt=""></i>
                                                                <div class="shop pull-left">
                                                                    <h1>DRINKS</h1>
                                                                    <p>DESCRIPTION OF DEAL</p>
                                                                </div>
                                                                <i class="fa fa-caret-left pull-right"></i>
                                                                <div class="clear"></div>
                                                            </a></h4>
                                                    </div>
                                                    <div id="collapse13" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <p>Text hear</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vspace-10"></div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-9">
                                    <div class="">
                                        <div class="ratings">
                                            <div class="col-xs-6 nopaddingrt dealodd">                                       

                                            </div>
                                            <div class="col-xs-6 padddingleft5 dealeven">

                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <div class="tabs">
                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs">
                                                    <li class="first_tab active"><a href="#call" data-toggle="tab"><i class="fa fa-map-marker"></i><span>CALL HISTORY</span></a></li>
                                                    <li class="secound_tab"><a href="#recom" data-toggle="tab"><i class="fa fa-map-marker"></i><span>RECOMMENDATIONS</span></a></li>
                                                    <li class="third_tab"><a href="#notes" data-toggle="tab"><i class="fa fa-map-marker"></i><span>NOTES</span></a></li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <div class="tab-pane active checkboxwrap tabwrap" id="call">
                                                        <ul>
                                                            <li><span class="one">THURS</span> <span class="two">SEPTEMBER 15, 2014</span> <span class="three">12:32 AM</span> <span class="four">MOVIE TICKETS</span> </li>
                                                            <li><span class="one">TUES</span> <span class="two">AUGUST 15, 2014</span> <span class="three">4:56 PM</span> <span class="four">DAY CARE</span> </li>
                                                            <li><span class="one">SUN</span> <span class="two">JULY 15, 2014</span> <span class="three">2:45 PM</span> <span class="four">SALON</span> </li>
                                                            <li><span class="one">THURS</span> <span class="two">SEPTEMBER 15, 2014</span> <span class="three">12:32 AM</span> <span class="four">MOVIE TICKETS</span> </li>
                                                            <li><span class="one">TUES</span> <span class="two">AUGUST 15, 2014</span> <span class="three">4:56 PM</span> <span class="four">DAY CARE</span> </li>
                                                            <li><span class="one">SUN</span> <span class="two">JULY 15, 2014</span> <span class="three">2:45 PM</span> <span class="four">SALON</span> </li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane checkboxwrap tabwrap" id="recom">
                                                        <ul>
                                                            <li><span class="one2">MOVIE THEATER</span> <span class="two2">REGAL OAKWOOD CINEMA - IRON MAN MOVIE</span> <span class="three2"><i class="fa fa-heart-o"></i></span></li>
                                                            <li><span class="one2">DAYCARE HOURS</span> <span class="two2">MON - FRI 7 AM - 9 PM, SAT & SUN 8 AM - 8 PM</span> <span class="three2"><i class="fa fa-heart-o"></i></span></li>
                                                            <li><span class="one2">SALON APMT</span> <span class="two2">PARADISE NAIL SALON - 9 AM WITH NANCY</span> <span class="three2"></span></li>
                                                            <li><span class="one2">MOVIE THEATER</span> <span class="two2">REGAL OAKWOOD CINEMA - IRON MAN MOVIE</span> <span class="three2"><i class="fa fa-heart-o"></i></span></li>
                                                            <li><span class="one2">DAYCARE HOURS</span> <span class="two2">MON - FRI 7 AM - 9 PM, SAT & SUN 8 AM - 8 PM</span> <span class="three2"><i class="fa fa-heart-o"></i></span></li>
                                                            <li><span class="one2">SALON APMT</span> <span class="two2">PARADISE NAIL SALON - 9 AM WITH NANCY</span> <span class="three2"></span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane" id="notes">...</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3">
                                    <div class="message">
                                        <i class="fa fa-pencil"></i><span>SEND MESSAGE</span>
                                        <div class="clear"></div>
                                        <div class="sms">
                                            <i>
                                                <img src="images/message1.png" alt=""></i>
                                            <input type="text" name="" value="SMS" onfocus="if (this.value == 'SMS')
                                                        this.value = '';" onblur="if (this.value == '')
                                                                    this.value = 'SMS'" />
                                        </div>
                                        <div class="push">
                                            <i>
                                                <img src="images/message1.png" alt=""></i>
                                            <input type="text" name="" value="PUSH" onfocus="if (this.value == 'PUSH')
                                                        this.value = '';" onblur="if (this.value == '')
                                                                    this.value = 'PUSH'" />
                                        </div>
                                        <div class="email">
                                            <i>
                                                <img src="images/message2.png" alt=""></i>
                                            <input type="email" name="" value="EMAIL" onfocus="if (this.value == 'EMAIL')
                                                        this.value = '';" onblur="if (this.value == '')
                                                                    this.value = 'EMAIL'" />
                                        </div>
                                        <div class="textarea">
                                            <textarea id="txtMessage" name="" cols="40" rows="6"></textarea>
                                            <input type="submit" value="SEND" name="" />
                                            <input type="reset" value="CANCEL" name="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer></footer>
            </div>
            <div id="myModal" class="modal fade subscribe" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <center>
                    <div class="mobile_screen">
                        <div class="img_screen">
                            <img src="images/mobile_top_bar.png" />
                            <div class="shadow">
                                <img src="images/mobile_top_shadow.png" />
                                <div class="text">
                                    <h1><span id="callername"></span></h1>
                                    <p><span id="callerphone"></span></p>
                                </div>
                            </div>
                            <div class="screen">
                                <img id="callerbgimg" src="images/mobile_screen2.png" /></div>
                        </div>
                        <div class="btn"><i class="fa fa-phone"></i><span onclick="call();">Answer Call</span></div>
                    </div>
                </center>
            </div>
            <div id="forecastModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content modal-elem">
                        <div class="clearfix"> 
                            <h4 class="modal-title">Forecast <span class="fa fa-times-circle cls-popup" data-dismiss="modal" data-target="#forecastModal"></span></h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-stripped table-bordered table-hover tbl-data" id="tblforecast" border="0" cellpadding="5" cellspacing="5" width="100%">
                                <thead>
                                    <tr>
                                      <th>Date</th>
                                      <th>High</th>
                                      <th>Low</th>
                                      <th>Notes</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>  
                </div>
            </div>
			<input type="hidden" id="txtSlugs" value=""/>
            <script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.2/twilio.min.js"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
            <script type="text/javascript" src="js/dashboard.js"></script>
            <script>
                var tc = '<?php echo trim($token); ?>';
                var k = '<?php echo $sqootApiKey;?>';
            </script>
            <script type="text/javascript" src="js/twilio.client.dashboard.js"></script> 
            <script type="text/javascript" src="js/jquery.js"></script>
            <script type="text/javascript" src="js/jquery.zclip.min.js"></script>
            <script type="text/javascript" src="js/bootstrap.min.js"></script>
            <script src="js/jquery.mCustomScrollbar.js"></script>
            <script>
                $(document).ready(function () {
                    // $('#myModal').modal('show');
					$(".checkboxwrap").mCustomScrollbar();
                    //initialize(37.332332611083984, -122.03121948242188);
					populateCategories(k);
					uid = '543254ab741b8c463638ba41';
					at = ''; //'eR99pBZ0jDZUnhL4daWshsobqpAhDju7XAcUhnCWHEwhbaCsLG5ScfmI93WU8xAJ';
					lat = 0; //40.753726959228516;
					lng  = 0; //-73.97865295410156;
					popData(uid, at, lat, lng, k);	
                });
            </script>
    </body>
</html>