<style>
.img-thumbnail {
	/*background-image: url("https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xta1/v/t1.0-1/p160x160/10423936_10152829833966849_5248358614851551197_n.jpg?oh=b36dba3c744f734b93488276630e8994&amp;oe=578AEA84&amp;__gda__=1464744443_da9f7021373ec571cb8b1e1d5a8668e4");
	*/
	/*background-image: url("{{ URL::to('/') }}/img/nhi.jpg");*/
	height: 120px;
	width: 120px;
	border: 3px solid #73AD21;
	background-size: contain;
}
.colored-tag {
	position: relative;
	left: 62px;
	top: 114px;
	opacity: 0.5;

}
</style>
<!--<div class="img-thumbnail" style="background-image: url({{ URL::to('/') }}/img/nhi.jpg)">-->
<div class="img-thumbnail" style="background-image:url({{ URL::to('/') }}/img/nhi.jpg)">
@if (1)
    <img class="colored-tag" src="{{ URL::to('/') }}/img/purple-tag.png">
@elseif (0)
    <img class="colored-tag" src="{{ URL::to('/') }}/img/red-tag.png">
@else
    <img class="colored-tag" src="{{ URL::to('/') }}/img/green-tag.png">
@endif

</div>
