<?php

/**
 * DAOFactory
 */
class DAOFactory{
	
	/**
	 * @return AlbumDAO
	 */
	public static function getAlbumDAO(){
		return new AlbumMySqlExtDAO();
	}

	/**
	 * @return AttachmentDAO
	 */
	public static function getAttachmentDAO(){
		return new AttachmentMySqlExtDAO();
	}

	/**
	 * @return BannerDAO
	 */
	public static function getBannerDAO(){
		return new BannerMySqlExtDAO();
	}

	/**
	 * @return BannerImageDAO
	 */
	public static function getBannerImageDAO(){
		return new BannerImageMySqlExtDAO();
	}

	/**
	 * @return BrandCategoryMappingDAO
	 */
	public static function getBrandCategoryMappingDAO(){
		return new BrandCategoryMappingMySqlExtDAO();
	}

	/**
	 * @return BrandTypeDAO
	 */
	public static function getBrandTypeDAO(){
		return new BrandTypeMySqlExtDAO();
	}

	/**
	 * @return CartDAO
	 */
	public static function getCartDAO(){
		return new CartMySqlExtDAO();
	}

	/**
	 * @return CityDAO
	 */
	public static function getCityDAO(){
		return new CityMySqlExtDAO();
	}

	/**
	 * @return ContentDAO
	 */
	public static function getContentDAO(){
		return new ContentMySqlExtDAO();
	}

	/**
	 * @return CountryDAO
	 */
	public static function getCountryDAO(){
		return new CountryMySqlExtDAO();
	}

	/**
	 * @return DeliveryDAO
	 */
	public static function getDeliveryDAO(){
		return new DeliveryMySqlExtDAO();
	}

	/**
	 * @return DeliveryStateDAO
	 */
	public static function getDeliveryStateDAO(){
		return new DeliveryStateMySqlExtDAO();
	}

	/**
	 * @return ImageDAO
	 */
	public static function getImageDAO(){
		return new ImageMySqlExtDAO();
	}

	/**
	 * @return ItemDAO
	 */
	public static function getItemDAO(){
		return new ItemMySqlExtDAO();
	}

	/**
	 * @return ItemAttributeDAO
	 */
	public static function getItemAttributeDAO(){
		return new ItemAttributeMySqlExtDAO();
	}

	/**
	 * @return ItemAttributeMappingDAO
	 */
	public static function getItemAttributeMappingDAO(){
		return new ItemAttributeMappingMySqlExtDAO();
	}

	/**
	 * @return ItemBrandDAO
	 */
	public static function getItemBrandDAO(){
		return new ItemBrandMySqlExtDAO();
	}

	/**
	 * @return ItemBrandMappingDAO
	 */
	public static function getItemBrandMappingDAO(){
		return new ItemBrandMappingMySqlExtDAO();
	}

	/**
	 * @return ItemCategoryDAO
	 */
	public static function getItemCategoryDAO(){
		return new ItemCategoryMySqlExtDAO();
	}

	/**
	 * @return ItemCategoryMappingDAO
	 */
	public static function getItemCategoryMappingDAO(){
		return new ItemCategoryMappingMySqlExtDAO();
	}

	/**
	 * @return ItemReviewDAO
	 */
	public static function getItemReviewDAO(){
		return new ItemReviewMySqlExtDAO();
	}

	/**
	 * @return ItemTagDAO
	 */
	public static function getItemTagDAO(){
		return new ItemTagMySqlExtDAO();
	}

	/**
	 * @return ItemTagMappingDAO
	 */
	public static function getItemTagMappingDAO(){
		return new ItemTagMappingMySqlExtDAO();
	}

	/**
	 * @return ItemsTempDAO
	 */
	public static function getItemsTempDAO(){
		return new ItemsTempMySqlExtDAO();
	}

	/**
	 * @return LangDAO
	 */
	public static function getLangDAO(){
		return new LangMySqlExtDAO();
	}

	/**
	 * @return OptionsDAO
	 */
	public static function getOptionsDAO(){
		return new OptionsMySqlExtDAO();
	}

	/**
	 * @return PermissionDAO
	 */
	public static function getPermissionDAO(){
		return new PermissionMySqlExtDAO();
	}

	/**
	 * @return RolePermissionDAO
	 */
	public static function getRolePermissionDAO(){
		return new RolePermissionMySqlExtDAO();
	}

	/**
	 * @return SaleOrderDAO
	 */
	public static function getSaleOrderDAO(){
		return new SaleOrderMySqlExtDAO();
	}

	/**
	 * @return SaleOrderItemDAO
	 */
	public static function getSaleOrderItemDAO(){
		return new SaleOrderItemMySqlExtDAO();
	}

	/**
	 * @return SocialMediaDAO
	 */
	public static function getSocialMediaDAO(){
		return new SocialMediaMySqlExtDAO();
	}

	/**
	 * @return UserDAO
	 */
	public static function getUserDAO(){
		return new UserMySqlExtDAO();
	}

	/**
	 * @return UserAddressTbDAO
	 */
	public static function getUserAddressTbDAO(){
		return new UserAddressTbMySqlExtDAO();
	}

	/**
	 * @return UserRoleDAO
	 */
	public static function getUserRoleDAO(){
		return new UserRoleMySqlExtDAO();
	}

	/**
	 * @return UserTypeDAO
	 */
	public static function getUserTypeDAO(){
		return new UserTypeMySqlExtDAO();
	}

	/**
	 * @return VehicleTypeDAO
	 */
	public static function getVehicleTypeDAO(){
		return new VehicleTypeMySqlExtDAO();
	}

	/**
	 * @return WarehouseDAO
	 */
	public static function getWarehouseDAO(){
		return new WarehouseMySqlExtDAO();
	}

	/**
	 * @return WishlistDAO
	 */
	public static function getWishlistDAO(){
		return new WishlistMySqlExtDAO();
	}


}
?>