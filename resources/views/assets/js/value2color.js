function rgb(r, g, b) {
    return `rgb(${r}, ${g}, ${b})`;
}

const colorMin = [255, 0, 0];
const colorMax = [0, 255, 0];

export default function (value, valueMin, valueMax) {
    if (value >= valueMax) {
        return rgb(...colorMax);
    }

    if (value <= valueMin) {
        return rgb(...colorMin);
    }

    const d = (value - valueMin) / Math.abs(valueMax - valueMin);

    return rgb(
        Math.round(colorMin[0] + (colorMax[0] - colorMin[0]) * d),
        Math.round(colorMin[1] + (colorMax[1] - colorMin[1]) * d),
        Math.round(colorMin[2] + (colorMax[2] - colorMin[2]) * d)
    );
}
