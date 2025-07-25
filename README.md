[Castellano](README.es.md)

<p align="center">
    <img src="https://github.com/eusonlito/GPS-Tracker/assets/644551/ef440878-fde8-4ec0-95db-c28e968f3249">
</p>

# GPS Tracker (Laravel 12 + PHP 8.2 + MySQL 8)

Open source GPS device management platform developed using Laravel 12, PHP 8.2 and MySQL 8. This comprehensive GPS tracking solution is designed to offer robust performance and an intuitive user interface, suitable for both individual users and companies that need to manage multiple tracking devices. This platform is intended as a possible simple alternative to [Traccar](https://github.com/traccar/traccar).

### Supported Devices

* **Sinotrack**: Confirmed ST-90X models using the Sinotrack protocol.
* **Coban**: TK303G model confirmed using GP103 protocol.
* **Teltonika**: By TCP using Teltonika protocol.
* **Concox** and **JimiLab**: JM-LL01 model confirmed via GT06 protocol.
* **Queclink**: Confirmed model GV500MA using Queclink protocol.
* **OsmAnd**: Using HTTP OsmAnd protocol.
* **iTriangle / Aquila**: Using the Aquila protocol.
* **TKStar**: Using the TK102 protocol.

### Features

* **Modern platform with user-friendly interface:** The platform uses Laravel 12 to provide a smooth user experience and an attractive graphical interface.
* **PHP 8.2 compatibility:** Leverages the latest features of PHP 8.2, including performance and security enhancements. It is also compatible with higher versions of PHP.
* **Data Management with MySQL 8:** Uses MySQL 8.0.12 or higher for efficient and secure management of large volumes of tracking data, as well as extensive support for GIS functionality.
* **Real-Time Tracking:** Allows users to track the location and status of their Sinotrack ST-90x devices in real time.
* **Detailed Reporting:** Generates comprehensive reports that aid in decision making and data analysis.
* **Alarms and Notifications:** Configure custom alarms (geofence, motion, speed, etc...) for specific events related to the tracking devices. Notifications can be configured via Telegram.
* **Multi-User Support:** Supports the creation of multiple user accounts with different levels of access and permissions.
* **Public Environment:** If you wish you can generate links for individual trips and share them publicly. You can also directly share a device where all its trips will be publicly visible.

### Requirements

- Linux SO
- PHP 8.2 or higher (bcmath bz2 intl mbstring opcache pdo_mysql pcntl redis sockets xsl zip)
- MySQL 8.0.12 or higher
- Redis

### Demo

You can test the demo version at https://tracker-demo.lito.com.es/

### Documentation

* [Local Installation](https://github.com/eusonlito/GPS-Tracker/wiki/%5BEN%5D-Local-Installation)
* [Docker Installation](https://github.com/eusonlito/GPS-Tracker/wiki/%5BEN%5D-Docker-Installation)
* [Initial Configuration](https://github.com/eusonlito/GPS-Tracker/wiki/%5BEN%5D-Initial-Configuration)
* [Console Commands](https://github.com/eusonlito/GPS-Tracker/wiki/%5BEN%5D-Console-Commands)
* [API](https://github.com/eusonlito/GPS-Tracker/wiki/%5BEN%5D-API)
* [SMS Configuration to Sinotrack Devices](https://github.com/eusonlito/GPS-Tracker/wiki/%5BEN%5D-SMS-Configuration-to-Sinotrack-Devices)

### Screenshots

Screenshots are in english, you can change the system language to spanish.

![screencapture-tracker-2023-11-22-09_36_09](https://github.com/eusonlito/GPS-Tracker/assets/644551/103bb4d5-34c0-4677-9a6f-4137060293ee)
![screencapture-tracker-2023-11-22-09_36_27](https://github.com/eusonlito/GPS-Tracker/assets/644551/87afab20-4522-42ec-9bc1-12c7955feab4)
![screencapture-tracker-trip-2023-11-22-09_36_37](https://github.com/eusonlito/GPS-Tracker/assets/644551/90e94c47-cfad-4a76-9c49-95bf6330f312)
![screencapture-tracker-trip-59-2023-11-22-09_37_23](https://github.com/eusonlito/GPS-Tracker/assets/644551/48314ef5-a983-493d-8331-7f455b6d04aa)
![screencapture-tracker-trip-59-stat-2023-11-22-09_37_30](https://github.com/eusonlito/GPS-Tracker/assets/644551/b0231c9c-c94a-4f92-bebe-42946f92876b)
![screencapture-tracker-trip-59-map-2023-11-22-09_37_38](https://github.com/eusonlito/GPS-Tracker/assets/644551/f236c92f-1543-4f11-a0d9-1b2a52b6f5ba)
![screencapture-tracker-trip-59-position-2023-11-22-09_37_47](https://github.com/eusonlito/GPS-Tracker/assets/644551/f96b1d3d-2dd9-4fb2-9e1d-6f9fc6c03b8a)
![screencapture-tracker-trip-59-merge-2023-11-22-09_37_54](https://github.com/eusonlito/GPS-Tracker/assets/644551/17569986-27d1-489a-8229-56a3f7968d18)
![screencapture-tracker-refuel-2023-11-22-09_38_13](https://github.com/eusonlito/GPS-Tracker/assets/644551/d3dfb646-58f8-421c-ba3c-f1b9f9f07720)
![screencapture-tracker-refuel-58-2023-11-22-09_38_20](https://github.com/eusonlito/GPS-Tracker/assets/644551/8c8fa9d9-d865-4eea-ba72-107ea11edd19)
![screencapture-tracker-maintenance-2023-11-22-09_38_25](https://github.com/eusonlito/GPS-Tracker/assets/644551/cf479211-852b-42da-90f3-f829d5d6e063)
![screencapture-tracker-maintenance-2-2023-11-22-09_38_30](https://github.com/eusonlito/GPS-Tracker/assets/644551/14b1fe07-2e8b-4741-8d4b-eb27542eedc1)
![screencapture-tracker-maintenance-2-item-2023-11-22-09_38_35](https://github.com/eusonlito/GPS-Tracker/assets/644551/ae2f18d6-2489-44ff-afe3-37e0c9ebb68a)
![screencapture-tracker-maintenance-item-2023-11-22-09_38_40](https://github.com/eusonlito/GPS-Tracker/assets/644551/ae377753-53be-42db-bbd2-d8fddceaf6f1)
![screencapture-tracker-vehicle-2023-11-22-09_38_45](https://github.com/eusonlito/GPS-Tracker/assets/644551/e68bcb6e-8f16-4e5a-bffb-56670c6af33e)
![screencapture-tracker-vehicle-1-2023-11-22-09_38_50](https://github.com/eusonlito/GPS-Tracker/assets/644551/f8236e28-03bf-44f3-8131-48e9d2bf72b9)
![screencapture-tracker-vehicle-1-device-2023-11-22-09_38_56](https://github.com/eusonlito/GPS-Tracker/assets/644551/854f2f77-d673-4625-9db5-8c4222024c08)
![screencapture-tracker-vehicle-1-alarm-2023-11-22-09_39_02](https://github.com/eusonlito/GPS-Tracker/assets/644551/bc53f72e-77d5-425f-b68b-1308130b047e)
![screencapture-tracker-device-2023-11-22-09_39_08](https://github.com/eusonlito/GPS-Tracker/assets/644551/116a55df-b42c-47af-847a-a7985ed20198)
![screencapture-tracker-device-1-2023-11-22-09_39_13](https://github.com/eusonlito/GPS-Tracker/assets/644551/ac13ba33-9c8d-496f-b45e-84d61f1a5d9a)
![screencapture-tracker-device-1-transfer-2023-11-22-09_39_20](https://github.com/eusonlito/GPS-Tracker/assets/644551/a04b16d2-62d4-482a-aa6a-031c4dd55d21)
![screencapture-tracker-device-map-2023-11-22-09_39_30](https://github.com/eusonlito/GPS-Tracker/assets/644551/3b465e6c-9202-425b-b3c3-1f4d936928e2)
![screencapture-tracker-alarm-2023-11-22-09_39_36](https://github.com/eusonlito/GPS-Tracker/assets/644551/7250076c-87ee-4e65-9d39-703bc8b0b086)
![screencapture-tracker-alarm-2-2023-11-22-09_39_42](https://github.com/eusonlito/GPS-Tracker/assets/644551/56ebbcb8-cd6e-47a5-82da-fd476828d65a)
![screencapture-tracker-alarm-create-2023-11-22-09_40_33](https://github.com/eusonlito/GPS-Tracker/assets/644551/c675bf1c-ba39-496c-a157-e7bb0d35e3c4)
![screencapture-tracker-profile-2023-11-22-09_40_39](https://github.com/eusonlito/GPS-Tracker/assets/644551/fb9ade96-11c5-4617-9e37-c9e09c914674)
![screencapture-tracker-configuration-2023-11-22-09_40_49](https://github.com/eusonlito/GPS-Tracker/assets/644551/419c8fbe-83ef-4edd-a14a-896c983cf0a4)
![screencapture-tracker-user-2023-11-22-09_40_55](https://github.com/eusonlito/GPS-Tracker/assets/644551/7fb8c18b-6947-4678-8738-f930eedb8d14)
![screencapture-tracker-user-1-2023-11-22-09_41_03](https://github.com/eusonlito/GPS-Tracker/assets/644551/23d3627e-5ccb-4ffc-90c6-126ba75609a6)
![screencapture-tracker-user-session-2023-11-22-09_41_09](https://github.com/eusonlito/GPS-Tracker/assets/644551/e57d91d0-acb7-4c0f-9109-ba7781875791)
![screencapture-tracker-server-status-2023-11-22-09_41_58](https://github.com/eusonlito/GPS-Tracker/assets/644551/0cb22188-d583-4bdf-b805-4d4254e4b887)
![screencapture-tracker-server-1-2023-11-22-09_42_07](https://github.com/eusonlito/GPS-Tracker/assets/644551/4f77ee90-051a-4e59-81d0-9451f592c00c)
![screencapture-tracker-server-log-2023-11-22-09_42_13](https://github.com/eusonlito/GPS-Tracker/assets/644551/6e32a9de-97ce-44e3-acb2-1702db290157)
![screencapture-tracker-timezone-2023-11-22-09_42_22](https://github.com/eusonlito/GPS-Tracker/assets/644551/35dec451-fea1-4734-a28c-c70a7dc13be0)
![screencapture-tracker-shared-trip-11da6b7b-88bd-11ee-b488-4cedfbcaec68-2023-11-22-09_42_50](https://github.com/eusonlito/GPS-Tracker/assets/644551/5f5e2fcc-1b33-48cb-b62d-1e5cfebde6c9)
![screencapture-tracker-shared-device-066b1953-88bd-11ee-b488-4cedfbcaec68-2023-11-22-09_42_57](https://github.com/eusonlito/GPS-Tracker/assets/644551/f0be5f69-0a8e-40c4-9e8d-72f6cb828ec7)

